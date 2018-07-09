<?php

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
        $user = new User;
        $user->username ="1507967";        
        $user->password=bcrypt("123456789");
        $user->email="sanjam531@gmail.com";
        $user->phone_number="9815333040";
        $user->type = "EXECUTIVE_MEMBER";
        $user->is_mailed="1";
        $user->is_active="1";
        $user->is_verified="1";
        $user->save();
    }
}
