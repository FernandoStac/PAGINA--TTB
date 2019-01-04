<?php

use Illuminate\Database\Seeder;
use App\User;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        
        User::create([
        	'name'=>'root',
            'email'=>'root@root.com',
            'password'=>bcrypt('root1.'),
            'role_id'=>1
        ]);

        User::create([
            'name'=>'Administrador',
            'email'=>'admin@admin.com',
            'password'=>bcrypt('admin2018.'),
            'role_id'=>2,
        ]);
          
    }
}
