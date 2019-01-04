<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{



    public function verification(){
        try {
             Mail::send('system.documents.send',['filename' => "prueba", 'name'=> "prueba"],function($msj){
                  $msj->subject('Se realizo una activación');
                  $msj->cc('javelie@outlook.com');
              });

             return true;
            
        } catch (Exception $e) {
            //$this->command->info($e);
            return false;
        }
    }
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
            $this->call(configTableSeeder::class);
        // if($this->verification()){
            $this->call(RolesTableSeeder::class);
            //$this->call(CompaniesTableSeeder::class);
            $this->call(UserTableSeeder::class);

            //$this->call(DocumentTableSeeder::class);
            $this->command->info("**************************************************************************************************");
            $this->command->info("Exito fernando, las migraciones se realizaron de manera correcta");
            $this->command->info("LA CONFUGURACION DEL CORREO FUE EXITOSA");
            $this->command->info("***************************************************************");

        // }else{
        //     $this->command->info("***************************************************************");
        //     $this->command->info("*******************************MENSAJE DE ERROR ULTRACATASTROFICO********************************");
        //     $this->command->info("No se completaron las migraciones");
        //     $this->command->info("*El correo no esta bien configurado:");
        //     $this->command->info("      Configure correctamente el archivo .env");
        //     $this->command->info("          MAIL_DRIVER=smtp");
        //     $this->command->info("          MAIL_HOST=?????????");
        //     $this->command->info("          MAIL_PORT=????");
        //     $this->command->info("          MAIL_USERNAME=???");
        //     $this->command->info("          MAIL_PASSWORD=?????????????");
        //     $this->command->info("          MAIL_ENCRYPTION=tls");
        //     $this->command->info("");
        //     $this->command->info("VERIFIQUE LA CONFIGURACION DEL CORREO Y VUELVA A EJECUTAR EL MISMO COMANDO");
        //     $this->command->info("****************************************************************************************************");

        // }
     
    }


    
}
