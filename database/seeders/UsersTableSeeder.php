<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dosen = new User;
        $user->username = "1731730001";
        $user->name = "Budi Gunawan M.Kom";
        $user->role = "koordinator";
        $user->password = bcrypt('1731730001');
        $user->save();
    }
}
