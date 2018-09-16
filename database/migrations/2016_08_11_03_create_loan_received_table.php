<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanReceivedTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $this->createLoanReceived();
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    $this->dropLoanReceived();
  }

  public function createLoanReceived()
  {
    Schema::create('loan_received', function (Blueprint $table) {
      $table->increments('loan_received_id');
      $table->string('status');
    });
  }

  public function dropLoanReceived(){
    Schema::dropIfExists('loan_received');
  }
}
