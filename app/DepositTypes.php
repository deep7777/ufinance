<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepositTypes extends Model
{
  protected $fillable = [
    'deposit_type'
  ];
  protected $table = 'deposit_types';
  public $timestamps = false;
}
