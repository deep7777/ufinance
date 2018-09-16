<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
  protected $fillable = ['first_name', 'last_name', 'email','username','password','added_on'];
  public $timestamps = false; 
  protected $table = 'admin';
  
  public static function createRules(){
    return array(
      'email'            => 'required|email|unique:admin',
      'username'         => 'unique:admin'
    );
  }
  
  public static function updateRules($id){
    return array(
      'email' => "required|unique:admin,email,$id,id",
      'username' => "required|unique:admin,username,$id,id",
    );
  }
}
