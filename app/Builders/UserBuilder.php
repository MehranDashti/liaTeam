<?php

namespace App\Builders;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use RuntimeException;

/**
 * Class UserBuilder
 * @package App\Builders
 */
class UserBuilder
{
    /**
     * Tries to return authenticated user info
     *
     * @return mixed
     */
    public function getUserInfo()
    {
        return User::all()->where('id', '=', 1)->first();
    }

    /**
     * Tries to create user according to input data
     *
     * @param array $payload
     * @return bool
     */
    public function createUser(array $payload): bool
    {
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $payload['name'] ?? null;
            $user->email = $payload['email'] ?? null;
            $user->password = app('hash')->make($payload['password'] ?? 'Password');
            $user->created_at = Carbon::now()->format('yy/m/d h:i:s');
            $user->updated_at = Carbon::now()->format('yy/m/d h:i:s');
            if (!$user->save()) {
                throw new RuntimeException('Can not store user');
            }
            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();

            return false;
        }
    }

    /**
     * Tries to fetch user with specific value and attribute
     *
     * @param string $attribute
     * @param $value
     * @return User
     */
    public function getSpecificUser(string $attribute, $value): User
    {
        $user = User::all()->where($attribute, '=', $value)->first();
        if (!$user instanceof User) {
            throw new RuntimeException('User not found');
        }

        return $user;
    }

    /**
     * Tries to update user attribute
     *
     * @param array $payload
     * @return bool
     */
    public function updateUser(array $payload)
    {
        $user = $this->getSpecificUser('email', $payload['email']);

        DB::beginTransaction();
        try {
            ($payload['email'] !== null) && $user->name = $payload['email'];
            ($payload['password'] !== null) && $user->password = app('hash')->make($payload['password']);
            $user->updated_at = Carbon::now()->format('yy/m/d h:i:s');
            if (!$user->save()) {
                throw new RuntimeException('Can not update user');
            }
            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();

            return false;
        }
    }

    /**
     * Tries to delete user
     *
     * @param int $id
     * @return bool
     * @throws Exception
     *
     * @author Mehran
     */
    public function deleteUser(int $id): bool
    {
        $user = $this->getSpecificUser('id', $id);

        return $user->delete();
    }
}
