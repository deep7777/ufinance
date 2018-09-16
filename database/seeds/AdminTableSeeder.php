<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('admin')->insert([
          'first_name' => "",
          'last_name' => "",
          'email' => "admin@gmail.com",
          'username' => "urja",
          'password' => md5('urja123'),
          'status_id'=>'1',
          'added_on' => Carbon::now()->format('Y-m-d H:i:s')
      ]);
    }
}
