<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentCustomersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $this->createAgentCustomers();
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    $this->dropAgentCustomers();
  }
  
  public function createAgentCustomers()
  {
    Schema::create('agent_customers', function (Blueprint $table) {
      $table->increments('customer_id');
      $table->integer('customer_agent_id')->length(10)->unsigned();
      $table->integer('account_type_id');
      $table->string('customer_account_no')->unique();
      $table->string('customer_first_name');
      $table->string('customer_middle_name');
      $table->string('customer_last_name');
      $table->tinyInteger('customer_gender');
      $table->string('customer_contact_no');
      $table->date('customer_account_opening_date');
      $table->integer('customer_daily_deposit');
      $table->text('customer_address');
      $table->string('customer_area');
      $table->tinyInteger('customer_account_status_id');
      $table->date('customer_account_reopening_date')->nullable();
      $table->tinyInteger('customer_loan_taken');
      $table->unsignedBigInteger('customer_total_deposit_amount')->nullable();
      $table->string('customer_reg_no')->unique()->nullable();
      $table->unsignedBigInteger('customer_amount')->nullable();
      $table->date('customer_account_maturity_date')->nullable();
      $table->float('customer_interest_rate')->nullable();
      $table->integer('customer_tenure')->nullable();
      $table->double('customer_maturity_value',15,2)->nullable();
    });
    
    Schema::table('agent_customers', function($table) {
      $table->foreign('customer_agent_id')->references('agent_id')->on('agents');
    });
  }

  public function dropAgentCustomers(){
    Schema::dropIfExists('agent_customers');
  }
}
