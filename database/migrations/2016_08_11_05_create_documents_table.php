<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $this->createDocuments();
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    $this->dropDocuments();
  }

  public function createDocuments()
  {
    Schema::create('documents', function (Blueprint $table) {
      $table->increments('document_id');
      $table->string('document_name');
    });
  }

  public function dropDocuments(){
    Schema::dropIfExists('documents');
  }
}
