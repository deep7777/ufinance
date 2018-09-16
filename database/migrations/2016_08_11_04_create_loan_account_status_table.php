<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanAccountStatusTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $this->createLoanAccountStatus();
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    $this->dropLoanAccountStatus();
  }

  public function createLoanAccountStatus()
  {
    Schema::create('loan_account_status', function (Blueprint $table) {
      $table->increments('loan_account_status_id');
      $table->string('draft');//approved||rejected||holding
    });
  }

  public function dropLoanAccountStatus(){
    Schema::dropIfExists('loan_account_status');
  }
}
