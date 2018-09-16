<?php

use Illuminate\Database\Seeder;
class AccountStatusTableSeeder extends Seeder
{

    public function run()
    {
      $account_status = array("Active","Inactive","Reopen");
      foreach ($account_status as $account_statu){
        DB::table('account_status')->insert([
          'status_name' => $account_statu
        ]);
      }
    }
}