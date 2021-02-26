<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
            'confirm_password' => $request['confirm_password'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:30',
            'email' => 'required|email',
            'password' => 'required|min:6|max:8',
            'confirm_password' => 'required|min:6|max:8',
        ];

        $messages = [
            'required' => 'Error',
            'email' => 'Invalid email',
            'password' => 'Password must be between 6-8 characters',
        ];

        $data = $request->validate($rules, $messages);
        $compemail = DB::select('select * from users where email = ?', [$request["email"]]);
        
        if ($request["password"] == $request["confirm_password"]){
            if (!$compemail){
                $user = User::create($data);
                return response()->json(['data' => $user], 200);
            } else {
                return response()->json(['error'=> 'The email already exists'], 422);
            }
        } else {
            return response()->json(['error'=> 'The password must be the same'], 422);
        }

        /*$data = $this->transformAndValidateRequest(UserResource::class, $request, $rules);
        $user= User::create($data);
        return $this->showOne($user, 201);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['Success'=> 'Delete correct'], 200);
    }
}
