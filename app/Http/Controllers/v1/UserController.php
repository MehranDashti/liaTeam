<?php

namespace App\Http\Controllers\v1;

use App\Builders\UserBuilder;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class UserController
 * @package App\Http\Controllers\v1
 */
class UserController extends Controller
{
    /**
     * Display info of logged in user
     *
     * @param UserBuilder $userBuilder
     * @return JsonResponse
     */
    public function index(UserBuilder $userBuilder)
    {
        return $this->success($userBuilder->getUserInfo(), 200);
    }

    /**
     * @param Request $request
     * @param UserBuilder $userBuilder
     * @return JsonResponse
     */
    public function create(Request $request, UserBuilder $userBuilder): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $payload = $request->only('name', 'email', 'password');
        if ($userBuilder->createUser($payload)) {
            return $this->success('User has been created successfully', 201);
        }

        return $this->error('Can not create user!', 500);
    }

    /**
     * @param string $id
     * @param UserBuilder $userBuilder
     * @return JsonResponse
     */
    public function show(string $id, UserBuilder $userBuilder): JsonResponse
    {
        try {
            return $this->success($userBuilder->getSpecificUser('id', (int)$id), 200);
        } catch (Exception $exception) {
            return $this->error('User not found', 404);
        }
    }

    /**
     * @param Request $request
     * @param UserBuilder $userBuilder
     * @return JsonResponse
     */
    public function update(Request $request, UserBuilder $userBuilder): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'email' => 'required|email',
            'password' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $payload = $request->only('name', 'email', 'password');
        if ($userBuilder->updateUser($payload)) {
            return $this->success('User has been updated successfully', 200);
        }

        return $this->error('Can not update user!', 500);
    }

    /**
     * @param $id
     * @param UserBuilder $userBuilder
     * @return JsonResponse
     */
    public function delete($id, UserBuilder $userBuilder): JsonResponse
    {
        if ($userBuilder->deleteUser($id)) {
            return $this->success('User has been deleted', 200);
        }

        return $this->error('Can not delete user!', 500);
    }
}
