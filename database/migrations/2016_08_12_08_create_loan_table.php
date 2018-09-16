<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $this->createLoan();
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    $this->dropLoan();
  }

  public function createLoan()
  {

    Schema::create('loan', function (Blueprint $table) {
      $table->increments('loan_id');
      $table->integer('agent_id');
      $table->string('customer_account_no');
      $table->integer('daily_collection_amount');
      $table->date('collection_date');
      
      $table->index('customer_account_no');
      $table->index('daily_collection_amount');
    });
  }

  public function dropLoan(){
    Schema::dropIfExists('loan');
  }
}
