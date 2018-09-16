<?php

use Illuminate\Database\Seeder;

class DocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $documents = array(
        "Address Proof",
        "PAN",
        "Cheque",
        "Aadhar Card",
        "Light Bill",
        "VoterID",
        "Rent Agreement",
        "ITR",
        "Photo"
      );
      
      foreach ($documents as $document){
        DB::table('documents')->insert([
          'document_name' => $document
        ]);
      }
    }
}
