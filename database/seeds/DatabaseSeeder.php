<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StaffTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        /*
        php artisan db:seed --class=AccountStatusTableSeeder 
        php artisan db:seed --class=DepositTypesSeeder
        php artisan db:seed --class=DocumentsSeeder
        php artisan db:seed --class=LoanAccountStatusSeeder
        php artisan db:seed --class=LoanReceivedSeeder
        php artisan db:seed --class=LoanStatusSeeder
        php artisan db:seed --class=StaffSeeder
        */
    }
}
