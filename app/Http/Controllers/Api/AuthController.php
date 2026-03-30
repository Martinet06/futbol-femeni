<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return $this->sendError('Unauthorised.', ['error' => 'Credencials incorrectes'], 401);
        }

        $authUser = $request->user();
        $result['token'] = $authUser->createToken('MyAuthApp')->plainTextToken;
        $result['name'] = $authUser->name;

        return $this->sendResponse($result, 'User signed in');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        try {
            $input = $validator->validated();
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);
            $result['token'] = $user->createToken('MyAuthApp')->plainTextToken;
            $result['name'] = $user->name;

            return $this->sendResponse($result, 'User created successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Registration Error', $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        $user = request()->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        $success['name'] = $user->name;
        return $this->sendResponse($success, 'User successfully signed out.');
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return $this->sendResponse([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'equip_id' => $user->equip_id,
            'permissions' => [
                'estadis' => [
                    'create' => $user->can('create', \App\Models\Estadi::class),
                    'update' => $user->can('update', \App\Models\Estadi::class),
                    'delete' => $user->can('delete', \App\Models\Estadi::class),
                ],
                'equips' => [
                    'create' => $user->can('create', \App\Models\Equip::class),
                    'update' => $user->can('update', \App\Models\Equip::class),
                    'delete' => $user->can('delete', \App\Models\Equip::class),
                ],
                'partits' => [
                    'create' => $user->can('create', \App\Models\Partit::class),
                    'update' => $user->can('update', \App\Models\Partit::class),
                ],
                'jugadores' => [
                    'create' => $user->can('create', \App\Models\Jugadora::class),
                    'update' => $user->can('update', \App\Models\Jugadora::class),
                    'delete' => $user->can('delete', \App\Models\Jugadora::class),
                ],
            ]
        ], 'User profile');
    }
}
