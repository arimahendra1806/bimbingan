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
        $user->username = "1780123499";
        $user->name = "Budi Gunawan";
        $user->role = "koordinator";
        $user->password = bcrypt('12345678');
        $user->save();
    }
}
