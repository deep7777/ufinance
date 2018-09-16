<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Expenses;
use Illuminate\Session;

class ExpenseController extends Controller
{
  public function __construct(Request $request){
    //$this->middleware('userAuth');    
  }
  
  public function listExpense(){
    $expense = Expenses::orderBy('expense_date','DESC')->get();
    return view('expense/list_expense',['expenses_list'=>$expense]);
  }
  
  public function addExpense(){
    return view('expense/add_expense');
  }
  
  public function editExpense(Request $request){
     $id = $request->segment('3');
     $expense = Expenses::where('expense_id', $id)->first();
     $data = [
        'expense'=>$expense
     ];
     if ($expense) {
       return view('expense/edit_expense',compact('expense'),$data);
     }else{
       return view('errors/record_not_found',['msg'=>'Record not Found']);
     }
  }
  
  public function updateExpense(Request $request){
    // create the validation rules ------------------------
    $id = $request->id;
    
    $this->updateExpenseRecord($request);
    
    return redirect('expense/listExpense');
  }
  
  public function createExpense(Request $request,  Expenses $expense){
    $this->saveExpense($request, $expense);
    return back()->with('success','Expense Created.');
  }
  
  public function updateExpenseRecord($request){
    $id = $request->id;
    $expense = new \stdClass();
    $expense->expense_name = ucwords($request->expense_name);
    $expense->expense_amount = ucwords($request->expense_amount);
    $expense->expense_date = $this->dateFormat($request->expense_date);
    $expense->expense_desc = $request->expense_desc;
    $expense->expense_purpose = $request->expense_purpose;
    $update_expense = (array) $expense;
    Expenses::where('expense_id',$id)->update($update_expense);
  }
  
  public function saveExpense($request,$expense){
    $expense->expense_name = ucwords($request->expense_name);
    $expense->expense_amount = ucwords($request->expense_amount);
    $expense->expense_date = $this->dateFormat($request->expense_date);
    $expense->expense_desc = $request->expense_desc;
    $expense->expense_purpose = $request->expense_purpose;
    $expense->save();
  }
  
  public function deleteExpense(Request $request){
    $id = $request->id;
    $expense = Expenses::where('expense_id', $id)->first();
    if ($expense) {
      Expenses::where('expense_id', $id)->delete();
      return "success";
    }else{
      return "record not found";
    }
  }
  
  public function dateFormat($date){    
    if($date!=''){
      list($day,$month,$year) = explode("/",$date);
      $date = $year."-".$month."-".$day;
    }
    return $date;
  }
}
