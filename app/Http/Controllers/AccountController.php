<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        if (Auth::user()->role != 'admin') {
            route('dashboard');
        }
        //
        $data = User::all();
        return view('Account', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    //    $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
    //         'password' => ['required', 'confirmed'],
    //         'role' => 'require',
    //     ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->string('password')),
            'role' => $request->role,
        ]);

        event(new Registered($user));

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function update2(Request $request)
    {
        // dd($request->all());

        // $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        //     'role' => 'required',
        //     'id' => 'required',
        // ]);

        $user = User::findOrFail($request->id);

        if ($request->password != null) {
            // $request->validate(['password' => ['required', 'confirmed']]);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->string('password'))
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);

            $user->save();

            return back();
        }
    }

    public function store2(Request $request) {}
    public function destroy2(Request $request)
    {
        $destroy = User::findOrFail($request->id);
        $destroy->delete();
        return back();
    }
}
