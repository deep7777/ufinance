<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class StaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
      DB::table('staff')->insert([
          'first_name' => "",
          'last_name' => "",
          'email' => "staff@gmail.com",
          'username' => "staff",
          'password' => md5('staff123'),
          'mobile_no' => "",
          'status_id'=>'1',
          'added_on' => Carbon::now()->format('Y-m-d H:i:s')
      ]);
    }
}
