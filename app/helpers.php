<?php

function dmy($date){
  if($date!=''){
    if($date=="0000-00-00"  || $date==NULL){
      $date = "";
    }else{
      $date = date('d/m/Y', strtotime($date));
    }
  }
  return $date;
}

function getAgentName($obj){
  $str = '';
  if(isset($obj->agent_first_name) && isset($obj->agent_last_name)){
    $str = $obj->agent_first_name." ".$obj->agent_last_name;
  }
  return $str;
}

function getCustomerName($obj){
  $str = '';
  if(isset($obj->customer_first_name) && isset($obj->customer_last_name)){
    $str = $obj->customer_first_name." ".$obj->customer_last_name;
  }
  return $str;
}

function getCurrentMonthYear(){
  $my = date('m/Y'); //month year
  return $my;
}

function getCurrentDate(){
  $date = date('d/m/Y'); //current date
  return $date;
}

function getDay($i,$year_month){
  $date_str = $year_month."-".$i;
  $date = date('D', strtotime($date_str));
  return $date;
}

function getMYName($date){
  $date_str = $date."-01";
  $year_month = date('M Y', strtotime($date_str));
  return $year_month;
}

function getWithdrawalDateFormat($date){
  $year_month = date('d-M-Y', strtotime($date));
  return $year_month;
}

function getDayName($i,$year_month){
  $date_str = $year_month."-".$i;
  $date = date('D, M j, Y', strtotime($date_str));
  return $date;
}

function getTxtFieldName($i){
  $str = "txt_collection_amount_".$i;
  return $str;
}

function getCollectionAmount($i,$collection_amount){
  if($i<10){
    $i = sprintf("%02d", $i);
  }
  if(isset($collection_amount[$i])){
    return $collection_amount[$i];
  }else{
    return "";
  }
}

function required_str(){
  echo $html = '<span class="required">*</span>';
}

function getLoanAccountStatus($id){
  if($id!=""){
    $status = array("1"=>"Approved","2"=>"Reject","3"=>"Holding");
    return $status[$id];
  }else{
    return "";
  }
}

function getLoanReceivedStatus($id){
  if($id!=""){
    $status = array("1"=>"Yes","2"=>"No");
    return $status[$id];
  }else{
    return "";
  }
}

function getLoanStatus($id){
  if($id!=""){
    $status = array("1"=>"Running","2"=>"Closed");
    return $status[$id];
  }else{
    return "";
  }
}

function isLoanTaken($id){
  $status = (($id==1)?"Yes":"No");
  return $status;
}

function get_money_indian_format($amount, $suffix = 1){
    if($amount!=''){
      setlocale(LC_MONETARY, 'en_US');
      if (ctype_digit($amount) ) {
        // is whole number
        // if not required any numbers after decimal use this format
        $amount = money_format('%!.0n', $amount);
      }
      else {
        // is not whole number
        $amount = money_format('%!i', $amount);
      }
      return $amount;
    }else{
      return $amount;
    }
}