<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $this->createSalary();
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    $this->dropSalary();
  }

  public function createSalary()
  {

    Schema::create('salary', function (Blueprint $table) {
      $table->increments('salary_id');
      $table->integer('agent_id');
      $table->integer('agent_fixed_salary');
      $table->float('agent_comission',8,2);
      $table->float('agent_comission_per',8,2);
      $table->double('agent_total_salary',15,2);
      $table->date('agent_salary_paid_date');
    });
  }

  public function dropSalary(){
    Schema::dropIfExists('expenses');
  }
}
