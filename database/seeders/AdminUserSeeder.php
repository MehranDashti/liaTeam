<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'admin.liatem@liatem.ir';

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => $email,
            'password' => app('hash')->make('LiaTeam1399'),
            'created_at' => Carbon::now()->format('yy/m/d h:i:s'),
            'updated_at' => Carbon::now()->format('yy/m/d h:i:s')
        ]);

        $user = User::all()->where('email', '=', $email)->first();
        $user->assignRole('Admin');
    }
}
