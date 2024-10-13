<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if(!Auth::attempt($credentials)){
            return response([
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }
        $user = Auth::user();
        return $user->createToken($request->token)->plainTextToken;
    }

    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json(['message' => 'Logout Successfully']);
    }

    public function index()
    {
        return User::orderBy('id', 'desc')->get();
    }
    public function show(User $user)
    {
        return $user;
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);
        $requestData = $request->all();
        $requestData['created_user_id'] = Auth::user()->id;
        if($requestData['user_type'] == 'Admin'){
            $requestData['user_type'] = 0;
        }else{
            $requestData['user_type'] = 1;
        }
       
        if($request->hasFile('image')){
            $fileName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $fileName);
            $requestData['image'] = '/images/'.$fileName;
        }else{
            $requestData['image'] = '/images/profile.png';
        }
        
        return User::create([
            'name' => $requestData['name'],
            'email' => $requestData['email'],
            'password' => bcrypt($requestData['password']),
            'image' => $requestData['image'],
            'created_user_id' => $requestData['created_user_id'],
            'user_type' => $requestData['user_type']
        ]);
        
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required'
        ]);
        $user = User::find($request->id);
        $requestData = $request->all();
        $requestData['created_user_id'] = Auth::user()->id;
        if($requestData['user_type'] == 'Admin'){
            $requestData['user_type'] = 0;
        }else{
            $requestData['user_type'] = 1;
        }
        if($request->hasFile('image')){
            $fileName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $fileName);
            $requestData['image'] = '/images/'.$fileName;
        }
        $user->update($requestData);
        return $user;
    }
    public function destroy(User $user)
    {
        return $user->delete();
    }
}
