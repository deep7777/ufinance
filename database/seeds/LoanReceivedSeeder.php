<?php

use Illuminate\Database\Seeder;

class LoanReceivedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $loan_received = array("Yes","No");
      foreach ($loan_received as $loan){
        DB::table('loan_received')->insert([
            'status' => $loan
        ]);
      }
    }
}
