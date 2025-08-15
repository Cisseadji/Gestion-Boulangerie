<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    protected $UserService;

    public function __construct(UserService $userService)
    {
        $this->UserService = $userService;

        $this->middleware(function ($request, $next) {
            if (Gate::denies('manage-users')) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = $this->UserService->index();
        return response()->json($user,200);
    }

    public function store(UserRequest $request)
    {
        $result = $this->UserService->store($request->validated());
        return response()->json($result, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->UserService->show($id);
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {

        $user = $this->UserService->update($request->validated(), $id);
        return response()->json([
            'message' => 'user modifiée',
            'promotion' => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->UserService->destroy($id);
        return response()->json('', 204);
    }
}
