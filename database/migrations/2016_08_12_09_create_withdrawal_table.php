<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawalTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $this->createWithdrawal();
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    $this->dropWithdrawal();
  }

  public function createWithdrawal()
  {

    Schema::create('withdrawal', function (Blueprint $table) {
      $table->increments('withdrawal_id');
      $table->integer('agent_id');
      $table->string('customer_account_no');
      $table->integer('withdrawal_amount');
      $table->string('withdrawal_percentage');
      $table->date('withdrawal_date');
      $table->double('amount_in_hand',15,2);
      $table->integer('total_deposit');
      $table->double('total_balance',15,2);
      
      //Indexes
      $table->index('customer_account_no');
      $table->index('total_deposit');
      $table->index('total_balance');
    });
  }

  public function dropWithdrawal(){
    Schema::dropIfExists('withdrawal');
  }
}
