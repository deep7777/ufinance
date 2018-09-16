<?php

Route::get('/', 'HomeController@login');
Route::get('/admin', 'AdminController@index');
Route::get('/staff', 'StaffController@index');
Route::get('/agent', 'CustomerAccountController@dashboard');
Route::get('/agent/dashboard', 'CustomerAccountController@dashboard');
Route::get('/home', 'HomeController@index');
Route::get('/exportcustomer', ['uses' => 'ExportController@index']);
Route::get('/sendsms', ['uses' => 'SMSController@index']);


Route::post('/validateLogin', ['uses' => 'LoginController@validateLogin']);

Route::get('/logout', 'LogoutController@index');

Route::group(['middleware' => 'web','prefix' => 'admin'], function () {
  /***********************Admin Profile ****************************************/
  Route::get('/profile', ['uses' => 'AdminController@getAdminProfile']);
  Route::post('/updateProfile', ['uses' => 'AdminController@updateProfile']);
  Route::post('/getAgentSummaryList', ['uses' => 'AdminController@getAgentSummaryList']);
  
  /***********************End Admin Profile ****************************************/

  /***********************Create Staff****************************************/
  Route::get('/listStaff', ['uses' => 'AdminController@listStaff']);
  Route::get('/addStaff', ['uses' => 'AdminController@addStaff']);
  Route::get('/{staff}/editStaff', ['uses' => 'AdminController@editStaff']);
  Route::post('/createStaff', ['uses' => 'AdminController@createStaff']);
  Route::post('/updateStaff', ['uses' => 'AdminController@updateStaff']);
  Route::post('/deleteStaff', ['uses' => 'AdminController@deleteStaff']);
  /************************End Staff***************************************/
  
  
});

/***********************Create Agent****************************************/
Route::group(['middleware' => 'web','prefix' => 'agent'], function () {
  Route::get('/listAgent', ['uses' => 'AgentController@listAgent']);
  Route::get('/addAgent', ['uses' => 'AgentController@addAgent']);
  Route::get('/editAgent/{agent}', ['uses' => 'AgentController@editAgent']);
  Route::post('/createAgent', ['uses' => 'AgentController@createAgent']);
  Route::post('/updateAgent', ['uses' => 'AgentController@updateAgent']);
  Route::post('/deleteAgent', ['uses' => 'AgentController@deleteAgent']);
});
/************************End Agent***************************************/

/************************Create Customer***************************************/
Route::group(['middleware' => 'web','prefix' => 'customer'], function () {
  Route::get('/listCustomer', ['uses' => 'CustomerController@listCustomer']);
  Route::get('/addCustomer', ['uses' => 'CustomerController@addCustomer']);
  Route::get('/editCustomer/{customer}', ['uses' => 'CustomerController@editCustomer']);
  Route::get('/listSaving', ['uses' => 'CustomerAccountController@listSaving']);
  Route::get('/listDailyEntry', ['uses' => 'CustomerAccountController@listDailyEntry']);
  Route::get('/agentCustomers', ['uses' => 'CustomerAccountController@agentCustomers']);
  Route::get('/listLoan', ['uses' => 'CustomerAccountController@listLoan']);
  Route::post('/getAccounts', ['uses' => 'CustomerAccountController@getAccounts']);
  Route::post('/addDailyCollection', ['uses' => 'CustomerAccountController@addDailyCollection']);
  Route::post('/createCustomer', ['uses' => 'CustomerController@createCustomer']);
  Route::post('/updateCustomer', ['uses' => 'CustomerController@updateCustomer']);
  Route::post('/deleteCustomer', ['uses' => 'CustomerController@deleteCustomer']);
  Route::post('/getSavingInfo', ['uses' => 'CustomerAccountController@getSavingInfo']);
  Route::post('/addSavingDailyCollection', ['uses' => 'CustomerAccountController@addSavingDailyCollection']);
  Route::post('/getLoanInfo', ['uses' => 'CustomerAccountController@getLoanInfo']);
  Route::post('/addLoanDailyCollection', ['uses' => 'CustomerAccountController@addLoanDailyCollection']);
});
/************************End Customer***************************************/

/************************Create LoanRequirement***************************************/
Route::group(['middleware' => 'web','prefix' => 'loan_requirement'], function () {
  Route::get('/selectCustomer', ['uses' => 'LoanRequirementController@selectCustomer']);
  Route::get('/customerLoanApproved', ['uses' => 'LoanRequirementController@customerLoanApproved']);
  Route::get('/listApproval', ['uses' => 'LoanRequirementController@listApproval']);
  Route::get('/addRequirement', ['uses' => 'LoanRequirementController@addRequirement']);
  Route::get('/customerRequirement/{customer_id}', ['uses' => 'LoanRequirementController@customerRequirement']);  
  Route::get('/editLoanRequirement/{loan_id}', ['uses' => 'LoanRequirementController@editLoanRequirement']);
  Route::get('/editLoanApprovedRequirement/{loan_id}', ['uses' => 'LoanRequirementController@editLoanApprovedRequirement']);
  Route::get('/editApproval/{loan}', ['uses' => 'LoanRequirementController@editApproval']);
  Route::get('/getAgentCustomers/{agent_id}', ['uses' => 'LoanRequirementController@getAgentCustomers']);
  Route::post('/createCustomerRequirement', ['uses' => 'LoanRequirementController@createCustomerRequirement']);
  Route::post('/updateCustomerRequirement', ['uses' => 'LoanRequirementController@updateCustomerRequirement']);
  Route::post('/updateApproval', ['uses' => 'LoanRequirementController@updateApproval']);
  Route::post('/getClosingDate', ['uses' => 'LoanRequirementController@getClosingDate']);

});
/************************End LoanRequirement***************************************/

/***********************Start Expense****************************************/
Route::group(['middleware' => 'web','prefix' => 'expense'], function () {
  Route::get('/listExpense', ['uses' => 'ExpenseController@listExpense']);
  Route::get('/addExpense', ['uses' => 'ExpenseController@addExpense']);
  Route::get('/editExpense/{agent}', ['uses' => 'ExpenseController@editExpense']);
  Route::post('/createExpense', ['uses' => 'ExpenseController@createExpense']);
  Route::post('/updateExpense', ['uses' => 'ExpenseController@updateExpense']);
  Route::post('/deleteExpense', ['uses' => 'ExpenseController@deleteExpense']);
});
/************************End Expense***************************************/

/***********************Start Salary****************************************/
Route::group(['middleware' => 'web','prefix' => 'salary'], function () {
  Route::get('/listSalary', ['uses' => 'SalaryController@listSalary']);
  Route::get('/addSalary', ['uses' => 'SalaryController@addSalary']);
  Route::post('/getAgentSalary', ['uses' => 'SalaryController@getAgentSalary']);
  Route::get('/editSalary/{agent}', ['uses' => 'SalaryController@editSalary']);
  Route::post('/createSalary', ['uses' => 'SalaryController@createSalary']);
  Route::post('/updateSalary', ['uses' => 'SalaryController@updateSalary']);
  Route::post('/deleteSalary', ['uses' => 'SalaryController@deleteSalary']);
  Route::post('/calculateSalary', ['uses' => 'SalaryController@calculateSalary']);
  Route::post('/totalSalary', ['uses' => 'SalaryController@totalSalary']);
});
/************************End Salary***************************************/

/***********************Start Saving****************************************/
Route::group(['middleware' => 'web','prefix' => 'saving'], function () {
  Route::get('/listSaving', ['uses' => 'SavingController@listSaving']);
  Route::get('/addSaving', ['uses' => 'SavingController@addSaving']);
  Route::get('/getAgentSaving/{agent_id}', ['uses' => 'SavingController@getAgentSaving']);
  Route::get('/editSaving/{agent}', ['uses' => 'SavingController@editSaving']);
  Route::get('/getAgentCustomers/{agent_id}', ['uses' => 'SavingController@getAgentCustomers']);
  Route::post('/getMonthlyCustomerData/{customer_id}', ['uses' => 'SavingController@getMonthlyCustomerData']);
  Route::post('/addCustomerSaving', ['uses' => 'SavingController@addCustomerSaving']);
  Route::post('/createSaving', ['uses' => 'SavingController@createSaving']);
  Route::post('/updateSaving', ['uses' => 'SavingController@updateSaving']);
  Route::post('/deleteSaving', ['uses' => 'SavingController@deleteSaving']);
  Route::post('/calculateSaving', ['uses' => 'SavingController@calculateSaving']);
  Route::post('/totalSaving', ['uses' => 'SavingController@totalSaving']);
  Route::post('/getCustomerAccountInfo', ['uses' => 'SavingController@getCustomerAccountInfo']);
  //**************************From Staff ***************************************
  Route::get('/listSavingCustomer', ['uses' => 'SavingController@listSavingCustomer']);
  Route::post('/getCustomerSavingInfoFromStaff', ['uses' => 'SavingController@getCustomerSavingInfoFromStaff']);
  Route::post('/addCustomerSavingFromStaff', ['uses' => 'SavingController@addCustomerSavingFromStaff']);

});
/************************End Saving***************************************/

/***********************Start Loan****************************************/
Route::group(['middleware' => 'web','prefix' => 'loan'], function () {
  Route::get('/listLoan', ['uses' => 'LoanController@listLoan']);
  Route::get('/addLoan', ['uses' => 'LoanController@addLoan']);
  Route::get('/getAgentLoan/{agent_id}', ['uses' => 'LoanController@getAgentLoan']);
  Route::get('/editLoan/{agent}', ['uses' => 'LoanController@editLoan']);
  Route::get('/getAgentCustomers/{agent_id}', ['uses' => 'LoanController@getAgentCustomers']);
  Route::post('/getMonthlyCustomerData/{customer_id}', ['uses' => 'LoanController@getMonthlyCustomerData']);
  Route::post('/addCustomerLoan', ['uses' => 'LoanController@addCustomerLoan']);
  Route::post('/createLoan', ['uses' => 'LoanController@createLoan']);
  Route::post('/updateLoan', ['uses' => 'LoanController@updateLoan']);
  Route::post('/deleteLoan', ['uses' => 'LoanController@deleteLoan']);
  Route::post('/calculateLoan', ['uses' => 'LoanController@calculateLoan']);
  Route::post('/totalLoan', ['uses' => 'LoanController@totalLoan']);
  Route::post('/getCustomerAccountInfo', ['uses' => 'LoanController@getCustomerAccountInfo']);
  //**************************From Staff ***************************************
  Route::get('/listLoanCustomer', ['uses' => 'LoanController@listLoanCustomer']);
  Route::post('/getCustomerLoanInfoFromStaff', ['uses' => 'LoanController@getCustomerLoanInfoFromStaff']);
  Route::post('/addCustomerLoanFromStaff', ['uses' => 'LoanController@addCustomerLoanFromStaff']);
});
/************************End Loan***************************************/

/***********************Start Withdrawal****************************************/
Route::group(['middleware' => 'web','prefix' => 'withdrawal'], function () {
  Route::get('/listWithdrawal', ['uses' => 'WithdrawalController@listWithdrawal']);
  Route::get('/getAgentCustomers/{agent_id}', ['uses' => 'WithdrawalController@getAgentCustomers']);  
  Route::post('/addCustomerWithdrawal', ['uses' => 'WithdrawalController@addCustomerWithdrawal']);
  Route::post('/getCustomerWithdrawalHistory', ['uses' => 'WithdrawalController@getCustomerWithdrawalHistory']);
  Route::post('/getCustomerInfo', ['uses' => 'WithdrawalController@getCustomerInfo']);
  Route::post('/getCustomerAccountInfo', ['uses' => 'WithdrawalController@getCustomerAccountInfo']);
  Route::post('/getAmountInHand', ['uses' => 'WithdrawalController@getAmountInHand']);
});
/************************End Withdrawal***************************************/

Route::group(['middleware' => 'web','prefix' => 'staff'], function () {
  Route::get('/profile', ['uses' => 'StaffController@getStaffProfile']);
  Route::post('/updateProfile', ['uses' => 'StaffController@updateProfile']);
});

/************************Create Customer***************************************/
Route::group(['middleware' => 'web','prefix' => 'profile'], function () {
  Route::get('/agent', ['uses' => 'ProfileController@getAgentProfile']);
  Route::post('/updateAgent', ['uses' => 'ProfileController@updateAgent']);
});

/************************Agent Reports ****************************************/
Route::get('/getAgentDailyCollectionReport', 'AgentReportsController@listAgentDailyCollectionReport');
Route::post('/getAgentDailyCollectionReport', 'AgentReportsController@getAgentDailyCollectionReport');

/************************Admin Reports ****************************************/
Route::get('/getLoanDefaulters', 'LoanDefaulterController@getLoanDefaulters');
Route::get('/getDailyDepositDefaulters', 'SavingDefaulterController@getDailyDepositDefaulters');
Route::get('/listAgentCustomerDailyCollection', 'ReportsController@listAgentCustomerDailyCollection');
Route::post('/getAgentCustomersDailyCollection', 'ReportsController@getAgentCustomersDailyCollection');
Route::get('/listAgentMonthlyCollectionData', 'ReportsController@listAgentMonthlyCollectionData');
Route::post('/getAgentMonthlyCollectionData', 'ReportsController@getAgentMonthlyCollectionData');
Route::get('/listAgentMonthlyDailyCollection', 'ReportsController@listAgentMonthlyDailyCollection');
Route::post('/getAgentMonthlyDailyCollection', 'ReportsController@getAgentMonthlyDailyCollection');
Route::get('/listCustomerSummary', 'ReportsController@listCustomerSummary');
Route::post('/getCustomerSummary', 'ReportsController@getCustomerSummary');
Route::get('/listCustomerTransaction', 'ReportsController@listCustomerTransaction');
Route::post('/getCustomerTransaction', 'ReportsController@getCustomerTransaction');
Route::get('/listLoanSummary', 'ReportsController@listLoanSummary');
Route::get('/reports/getAgentCustomers/{agent_id}', 'ReportsController@getAgentCustomers');
Route::post('/getCustomerLoanSummary', 'ReportsController@getCustomerLoanSummary');
Route::get('/listBalanceSheet', 'ReportsController@listBalanceSheet');
Route::post('/getBalanceSheet', 'ReportsController@getBalanceSheet');