<?php

namespace App\Exceptions;

use App\Traits\ResponseApi;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseApi;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e, $request) {
            if ($request->expectsJson() || $request->isJson() || $request->is('api/*')) {
                return $this->handleApiException($request, $e);
            }
        });
    }

    private function handleApiException($request, Throwable $exception): \Illuminate\Http\JsonResponse
    {
        try {
            $exception = $this->prepareException($exception);

            if ($exception instanceof \Illuminate\Http\Exceptions\HttpResponseException) {
                $exception = $exception->getResponse();
            }

            if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
                $exception = $this->unauthenticated($request, $exception);
            }

            if ($exception instanceof \Illuminate\Validation\ValidationException) {
                $exception = $this->convertValidationExceptionToResponse($exception, $request);
            }

            return $this->customApiResponse($exception);
        } catch (\Exception $e) {
            Log::error('Exception occurred during exception handling: ' . $e->getMessage());

            // Return a generic error response
            return $this->respondWithCustomData(['message' => 'Internal Server Error'], 500);
        }
    }


    private function customApiResponse($exception): \Illuminate\Http\JsonResponse
    {
        Log::info($exception);
        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } elseif (method_exists($exception, 'getCode') && $exception->getCode() != 0) {
            $statusCode = $exception->getCode();
        } else {
            $statusCode = 500;
        }

        $response = [];

        switch ($statusCode) {
            case 401:
                if (method_exists($exception, 'getMessage')) {
                    $response['message'] = $exception->getMessage();
                } else {
                    $response['message'] = $exception->original['message'];
                }
                break;
            case 422:
                $response['message'] = $exception->original['message'];
                $response['errors'] = $exception->original['errors'];
                break;
            case 404: // Add a case for 404 status code
                $response['message'] = $exception->getMessage();
                break;
            case 500:
                $response['message'] = 'Something went wrong...';
                break;
            default:
                $response['message'] = $exception->getMessage();
                break;
        }

        if (method_exists($exception, 'getCode')) {
            $response['code'] = $exception->getCode();
        }

        if (config('app.debug')) {
            if (method_exists($exception, 'getTrace')) {
                $response['trace'] = $exception->getTrace();
            }
        }


        $response['status'] = $statusCode;

        return $this->respondWithCustomData($response, $statusCode);
    }
}
