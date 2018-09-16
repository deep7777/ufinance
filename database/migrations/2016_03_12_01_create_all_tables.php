<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createStaff();
        $this->createAdmin();
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropStaff();
        $this->dropAdmin();
    }
    
    public function createStaff()
    {
      Schema::create('staff', function (Blueprint $table) {
          $table->increments('id');
          $table->string('first_name');
          $table->string('last_name');
          $table->string('email')->unique();
          $table->string('mobile_no');
          $table->string('username')->unique();
          $table->string('password');
          $table->tinyInteger('status_id');
          $table->rememberToken();
          $table->timestamp('added_on');
      });
    }
    
    public function createAdmin()
    {
      Schema::create('admin', function (Blueprint $table) {
          $table->increments('id');
          $table->string('first_name');
          $table->string('last_name');
          $table->string('email')->unique();
          $table->string('username')->unique();
          $table->string('password');
          $table->tinyInteger('status_id');
          $table->rememberToken();
          $table->timestamp('added_on');
      });
    }
    
    public function dropAdmin(){
      Schema::dropIfExists('admin');
    }
    
    public function dropStaff(){
      Schema::dropIfExists('staff');
    }
}
