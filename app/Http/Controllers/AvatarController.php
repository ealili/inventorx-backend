<?php

namespace App\Http\Controllers;

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

        return $file;
    }
}
