<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class testUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'user_id'=>'testuser',
            'connect_id'=>'033bd197-5a64-46af-9695-a3d8117daa0f',
            'email'=>'testuser@gmail.com',
            'password'=>'$2y$10$9AuEJT1OCRrupIsjwXcAouIOTD4iAcnDV1R/YQXQDvMS4iwPOCe1a'
        ]);
    }
}
