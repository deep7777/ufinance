<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanStatus extends Model
{
  protected $guarded = [];
  protected $table = 'loan_status';
  public $timestamps = false;
}
