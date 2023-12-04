<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image',
        ]);

        $file = Storage::putFile('avatars', $request->avatar);

        Auth()->user()->update(['avatar' => env('APP_URL') . '/storage/' . $file]);

        return ['avatar' => env('APP_URL') . '/storage/' . $file];
    }
}
