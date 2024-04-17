<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
      public function checkNameEmail(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');

        // Check if the name and email exist in the database
        $user = User::where('name', $name)->where('email', $email)->first();

        if ($user) {
            // If user exists, return response indicating user exists
            return response()->json(['exists' => true]);
        } else {
            // If user doesn't exist, save to the database
            $user = User::create([
                'name' => $name,
                'email' => $email
            ]);

            // Return response indicating user doesn't exist
            return response()->json(['exists' => false, 'user' => $user]);
        }
    }
}
