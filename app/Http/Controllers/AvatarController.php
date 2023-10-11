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

        $avatarName = time() . '.' . $request->avatar->getClientOriginalExtension();

        $file = Storage::putFile('avatars', $request->avatar);


        Auth()->user()->update(['avatar' => env('APP_URL') . '/storage/' . $file]);

        return $file;

        return asset('storage/' . $avatarName);

//        $request->avatar->move(public_path('avatars'), $avatarName);

        Auth()->user()->update(['avatar' => $avatarName]);

        return asset('storage/' . $avatarName);

        return response(['message' => 'Sucesss'], 200);
    }
}
