<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanRequirementTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $this->createLoanRequirement();
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
  
  public function createLoanRequirement()
  {
    Schema::create('loan_requirement', function (Blueprint $table) {
      $table->increments('loan_requirement_id');
      $table->integer('agent_id')->length(10)->unsigned();
      $table->string('customer_account_no')->unique();
      $table->integer('customer_id')->length(10)->unsigned();
      $table->unsignedBigInteger('loan_requirement_amount');
      $table->date('loan_file_login_date');
      $table->string('loan_document_list');
      $table->integer('loan_account_status_id')->nullable();
      $table->text('loan_comment');
      $table->integer('loan_approved_amount')->nullable();
      $table->date('loan_approved_date')->nullable();
      $table->unsignedBigInteger('loan_in_hand_amount')->nullable();
      $table->string('loan_per_day_collection');
      $table->integer('loan_tenure')->nullable();
      $table->date('loan_received_date')->nullable();
      $table->date('loan_closing_date')->nullable();
      $table->tinyInteger('loan_received_id')->nullable();
      $table->tinyInteger('loan_status_id')->nullable();
    });
    
    Schema::table('loan_requirement', function($table) {
      $table->foreign('agent_id')->references('agent_id')->on('agents');
      $table->foreign('customer_id')->references('customer_id')->on('agent_customers');
    });
  }

  public function dropLoan(){
    Schema::dropIfExists('loan_requirement');
  }
}
