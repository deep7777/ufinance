<?php

use Illuminate\Database\Seeder;

class LoanStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $loan_status = array("Running","Closed");
      foreach ($loan_status as $loan_status){
        DB::table('loan_status')->insert([
          'account' => $loan_status
        ]);
      }
    }
}
