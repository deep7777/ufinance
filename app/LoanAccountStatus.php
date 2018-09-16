<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanAccountStatus extends Model
{
  protected $guarded = [];
  protected $table = 'loan_account_status';
  public $timestamps = false;
}
