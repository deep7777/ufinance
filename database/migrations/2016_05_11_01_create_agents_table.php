<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createAgent();
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropAgent();
    }
    
    public function createAgent()
    {
      
      
      Schema::create('agents', function (Blueprint $table) {
        $table->increments('agent_id');
        $table->string('agent_first_name');
        $table->string('agent_last_name');
        $table->integer('agent_fixed_salary');
        $table->string('agent_address');
        $table->string('agent_primary_contact');
        $table->string('agent_secondary_contact');
        $table->string('username')->unique();
        $table->string('password');
        $table->date('agent_joining_date');
        $table->string('agent_account_active');
      });
    }
    
   
    public function dropAgent(){
      Schema::dropIfExists('agents');
    }
}
