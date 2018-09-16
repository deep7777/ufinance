<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    //
  protected $fillable = ['first_name', 'last_name', 'email','mobile_no','username','password','status_id'];
  protected $table = 'staff';
  public $timestamps = false;
  
  public static function createRules(){
    return array(
      'email'            => 'required|email|unique:staff',
      'username'         => 'unique:staff'
    );
  }
  
  public static function updateRules($id){
    return array(
      'email' => "required|unique:staff,email,$id,id",
      'username' => "required|unique:staff,username,$id,id",
    );
  }
}
