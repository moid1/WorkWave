<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Driver;

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

     public function driverLocation(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'users_id' => 'required|integer',
            'users_location' => 'required|string',
            'users_lat' => 'required|numeric',
            'users_long' => 'required|numeric',
        ]);

        // Create a new driver
        $driver = new Driver();
        $driver->users_id = $validatedData['users_id'];
        $driver->users_location = $validatedData['users_location'];
        $driver->users_lat = $validatedData['users_lat'];
        $driver->users_long = $validatedData['users_long'];
        $driver->save();

        // Return a success response
        return response()->json(['message' => 'Driver Location stored successfully'], 201);
    }
}
