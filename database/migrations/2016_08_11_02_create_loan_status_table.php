<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanStatusTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $this->createLoanStatus();
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    $this->dropLoanStatus();
  }

  public function createLoanStatus()
  {
    Schema::create('loan_status', function (Blueprint $table) {
      $table->increments('loan_status_id');
      $table->string('account');
    });
  }

  public function dropLoanStatus(){
    Schema::dropIfExists('loan_status');
  }
}
