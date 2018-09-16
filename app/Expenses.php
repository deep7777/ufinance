<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
  protected $guarded = [];
  protected $table = 'expenses';
  public $timestamps = false;
}
