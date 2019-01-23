<?php

use Illuminate\Database\Seeder;
use App\role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        role::create([
        	'name'=>'Super Usuario',
            'type'=>'root'
        ]);

        role::create([
        	'name'=>'Administrador',
            'type'=>'admin'
        ]);

        role::create([
        	'name'=>'Empresa',
            'type'=>'empresa'
        ]);

            role::create([
            'name'=>'Administrador 1',
            'type'=>'admin1'
        ]);

        role::create([
            'name'=>'Administrador 2',
            'type'=>'admin2'
        ]);

          role::create([
            'name'=>'Administrador 3',
            'type'=>'admin3'
        ]);


    }
}
