<?php

use Illuminate\Database\Seeder;
use App\role;
use App\menu;
use App\DescriptionAccess;

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

        //1
        menu::create([
            'name'=>'Inicio',
            'slug'=>'',
            'order'=>'0'
        ]);

        //2
        menu::create([
            'name'=>'Usuarios',
            'slug'=>'system/user.html',
            'order'=>'7'
        ]);

        //3
        menu::create([
            'name'=>'Empresas',
            'slug'=>'system/companie',
            'order'=>'3'
        ]);
        //4
        menu::create([
            'name'=>'Roles',
            'slug'=>'role',
            'order'=>'4'
        ]);

        //5
        menu::create([
            'name'=>'Menú',
            'slug'=>'menu',
            'order'=>'8'
        ]);

        //6
        menu::create([
            'name'=>'Permisos',
            'slug'=>'access',
            'order'=>'9'
        ]);


        //6
        menu::create([
            'name'=>'Documentos',
            'slug'=>'/document/general',
            'order'=>'1'
        ]);

        //7
        menu::create([
            'name'=>'Cargar Documentos',
            'slug'=>'/companie/document/load',
            'order'=>'2'
        ]);


        DescriptionAccess::create([
            'name'=>'Ver empresas',
            'menu_id'=>'3',
            'enabled'=>'true'
        ]);

        DescriptionAccess::create([
            'name'=>'Editar empresas',
            'menu_id'=>'3',
            'enabled'=>'true'
        ]);


        DescriptionAccess::create([
                    'name'=>'Eliminar empresas',
                    'menu_id'=>'3',
                    'enabled'=>'true'
                ]);


        DescriptionAccess::create([
                    'name'=>'Crear empresas',
                    'menu_id'=>'3',
                    'enabled'=>'true'
                ]);

         DescriptionAccess::create([
                    'name'=>'Eliminar documentos',
                    'menu_id'=>'3',
                    'enabled'=>'true'
                ]);

        DescriptionAccess::create([
                    'name'=>'Ver Roles',
                    'menu_id'=>'4',
                    'enabled'=>'true'
                ]);


        DescriptionAccess::create([
                    'name'=>'Crear Rol',
                    'menu_id'=>'4',
                    'enabled'=>'true'
                ]);

        DescriptionAccess::create([
                    'name'=>'Eliminar Rol',
                    'menu_id'=>'4',
                    'enabled'=>'true'
                ]);


        DescriptionAccess::create([
                    'name'=>'Editar Rol',
                    'menu_id'=>'4',
                    'enabled'=>'true'
                ]);
        DescriptionAccess::create([
                    'name'=>'Permisos del Rol',
                    'menu_id'=>'4',
                    'enabled'=>'true'
                ]);


        DescriptionAccess::create([
                    'name'=>'Ver usuarios',
                    'menu_id'=>'2',
                    'enabled'=>'true'
                ]);


        DescriptionAccess::create([
                    'name'=>'Crear Usuarios',
                    'menu_id'=>'2',
                    'enabled'=>'true'
                ]);


        DescriptionAccess::create([
                    'name'=>'Editar Usuarios',
                    'menu_id'=>'2',
                    'enabled'=>'true'
                ]);


        DescriptionAccess::create([
                    'name'=>'Ver permisos',
                    'menu_id'=>'6',
                    'enabled'=>'false'
                ]);


        DescriptionAccess::create([
                    'name'=>'Ver menu',
                    'menu_id'=>'5',
                    'enabled'=>'false'
                ]);


        DescriptionAccess::create([
                    'name'=>'Evaluador 1',
                    'menu_id'=>'3',
                    'enabled'=>'true'
                ]);


        DescriptionAccess::create([
                    'name'=>'Evaluador 2',
                    'menu_id'=>'3',
                    'enabled'=>'true'
                ]);


        DescriptionAccess::create([
                    'name'=>'Evaluador 3',
                    'menu_id'=>'3',
                    'enabled'=>'true'
                ]);


        DescriptionAccess::create([
                    'name'=>'Evaluador Maestro',
                    'menu_id'=>'3',
                    'enabled'=>'true'
                ]);


        DescriptionAccess::create([
                    'name'=>'Documentos',
                    'menu_id'=>'7',
                    'enabled'=>'true'
                ]);


        DescriptionAccess::create([
                    'name'=>'Cargar Documento',
                    'menu_id'=>'8',
                    'enabled'=>'true'
                ]);




    }
}
