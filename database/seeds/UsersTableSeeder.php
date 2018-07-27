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
        $user->username ="tpoAdminGNDEC5312";        
        $user->password=bcrypt("GNDECtpo2018#");
        $user->email="tpo@gndec.ac.in";
        $user->phone_number="9872219178";
        $user->type = "EXECUTIVE_MEMBER";
        $user->is_mailed="1";
        $user->is_active="1";
        $user->is_verified="1";
        $user->save();
    }
}
