<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $this->createExpenses();
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    $this->dropExpenses();
  }

  public function createExpenses()
  {
    Schema::create('expenses', function (Blueprint $table) {
      $table->increments('expense_id');
      $table->string('expense_name');
      $table->string('expense_purpose');
      $table->integer('expense_amount');
      $table->text('expense_desc');
      $table->date('expense_date');
    });
  }

  public function dropExpenses(){
    Schema::dropIfExists('expenses');
  }
}
