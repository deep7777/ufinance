<?php

use Illuminate\Database\Seeder;

class DepositTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $deposit_types = array("Saving Account","Super Saving Account","RD","FD");
      foreach ($deposit_types as $deposit_type){
        DB::table('deposit_types')->insert([
            'deposit_type' => $deposit_type
        ]);
      }
    }
}
