<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositTypesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $this->createDepositTypes();
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    $this->dropDepositTypes();
  }

  public function createDepositTypes()
  {
    Schema::create('deposit_types', function (Blueprint $table) {
      $table->increments('deposit_type_id');
      $table->string('deposit_type');
    });
  }

  public function dropDepositTypes(){
    Schema::dropIfExists('deposit_types');
  }
}
