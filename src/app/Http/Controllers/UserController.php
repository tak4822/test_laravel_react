<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use App\Http\Resources\UserResource;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', 'users');
        return UserResource::collection(User::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $this->authorize('edit', 'users');
        $user = User::create(
            $request->only('first_name', 'last_name', 'email', 'role_id') + ['password' => Hash::make(1234)]
        );

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', 'users');
        return new UserResource(User::with('role')->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $this->authorize('edit', 'users');
        $user = User::find($id);

        $user->update($request->only('first_name', 'last_name', 'email', 'role_id'));

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('edit', 'users');
        $user = User::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
