<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserPermissionRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserDestroyRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;

use App\Entities\User;
use App\Entities\Permission;

use Laravel\Passport\TokenRepository;

use Carbon\Carbon;

class UsersController extends Controller
{
    /**
     * List Users for table output.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $response = data_tables_response('User', $request, 'name');

        return response()->json($response);
    }

    /**
     * Show form to modify a user.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Create a user.
     *
     * @param UserCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(UserCreateRequest $request)
    {
        if ($request->input('type') == 'super') {
            $password = bcrypt($request->input('password'));
        } else {
            $password = bcrypt(str_random(30));
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $password
        ]);

        if ($request->input('type') == 'super') {
            $user->roles()->attach(1);
        } else {
            $user->roles()->attach(2);
        }

        $token = $user->createToken($user->email)->accessToken;

        return response()->json(array_merge($user->toArray(), ['token' => $token]));
    }

    /**
     * Update a User.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        if ($user->hasRole('super')) {
            if ($request->has('password')) {
                $user->password = bcrypt($request->input('password'));
                $token = $user->createToken($user->email)->accessToken;
            } else {
                $token = '';
            }
            $user->name = $request->input('name');
            $user->save();

            return response()->json(array_merge($user->toArray(), ['token' => $token]));
        } else {
            $user->name = $request->input('name');
            $user->save();

            return response()->json($user->toArray());
        }
    }

    /**
     * Reset a user's token.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset_token(Request $request, User $user)
    {
        $token = $user->createToken($user->email)->accessToken;

        return response()->json(array_merge($user->toArray(), ['token' => $token]));
    }

    public function destroy(UserDestroyRequest $request, User $user)
    {
        $user->delete();

        return redirect()->route('users');
    }
}
