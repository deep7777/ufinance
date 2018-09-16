<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanReceived extends Model
{
  protected $guarded = [];
  protected $table = 'loan_received';
  public $timestamps = false;
}
