<?php

use Illuminate\Database\Seeder;

class LoanAccountStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $status = array(
        "Applied",  
        "Approved",
        "Reject",
        "Holding"
      );
      
      foreach ($status as $status){
        DB::table('loan_account_status')->insert([
          'draft' => $status
        ]);
      }
    }
}
