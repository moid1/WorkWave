<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $managers = User::where('type', 1)->with('manager')->get();
        return view('manager.index', compact('managers'));
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createManager(Request $request)
    {

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create($request->all());

        Manager::create([
            'user_id' => $user->id,
            'manager_type' => $request->manager_type
        ]);

        return redirect('/register-manager')->with('success', 'Manager Created Successfully');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function updateManager(Request $request)
    {

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255']
        ]);

        $user = User::find($request->user_id);
        if ($user) {
            $user->name = $request->name;
            if ($request->password)
                $user->password = Hash::make($request->password);
            $user->update();
        }


        $manager = Manager::where('user_id', $user->id)->first();
        $manager->manager_type = $request->manager_type;
        $manager->update();


        return redirect('/register-manager')->with('success', 'Manager Updated Successfully');
    }

    public function showManagerDetails($id)
    {
        $user = User::whereId($id)->first();
        $manager = Manager::where('user_id', $id)->first();
        if ($user) {
            return view('manager.show', compact('user', 'manager'));
        }
        return back()->with('error', 'something bad happened');
    }
}
