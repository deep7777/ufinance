<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavingTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $this->createSaving();
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    $this->dropSaving();
  }

  public function createSaving()
  {

    Schema::create('saving', function (Blueprint $table) {
      $table->increments('saving_id');
      $table->integer('agent_id');
      $table->string('customer_account_no');
      $table->integer('daily_collection_amount');
      $table->date('collection_date');
      
      $table->index('customer_account_no');
      $table->index('daily_collection_amount');
    });
  }

  public function dropSaving(){
    Schema::dropIfExists('saving');
  }
}
