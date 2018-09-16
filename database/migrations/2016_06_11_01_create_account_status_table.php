<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountStatusTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $this->createAccountStatus();
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    $this->dropAccountStatus();
  }

  public function createAccountStatus()
  {
    Schema::create('account_status', function (Blueprint $table) {
      $table->increments('account_status_id');
      $table->string('status_name');
    });
  }

  public function dropAccountStatus(){
    Schema::dropIfExists('account_status');
  }
}
