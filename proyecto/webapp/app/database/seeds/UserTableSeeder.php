<?php

use Illuminate\Database\Seeder;
use App\User as User;
  
class UserTableSeeder extends Seeder {
  
    public function run() {
        User::truncate();
  
        User::create( [
            'email' => 'rolando.caldas@gmail.com' ,
            'password' => Hash::make( '123456' ) ,
            'name' => 'rolando' ,
        ] );
    }
}