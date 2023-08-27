<?php



use Illuminate\Support\Facades\Route;



use App\Http\Controllers\ProfileController;

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\AdminController;

use App\Http\Controllers\ExpenseController;

use App\Http\Controllers\PackageController;

use App\Http\Controllers\CustomerController;

use App\Http\Controllers\AdminCustomerController;

use App\Http\Controllers\WithdrawController;

use App\Http\Controllers\InvioceModelController;

use Illuminate\Support\Facades\Auth;



/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

|

| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| contains the "web" middleware group. Now create something great!

|

*/







// User Dashboard









Route::get('/', [DashboardController::class, 'welcome'])->name('welcome');





Route::group(['middleware' => 'auth'], function () {



    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/get/filter/date', [DashboardController::class, 'filterdate']);

    Route::get('/send/message', [DashboardController::class, 'sendmessage'])->name('sendmessage');

    Route::get('/send/message/single/{id}', [DashboardController::class, 'sendmessagesingle'])->name('sendmessage.single');



    // profile Routes

    Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('dashboard.profile');

    Route::post('/dashboard/profile/update', [ProfileController::class, 'update'])->name('dashboard.profile.update');

    Route::post('/dashboard/password/update', [ProfileController::class, 'updatepassword'])->name('dashboard.password.update');



    // Admin Routes

    Route::get('/dashboard/adminlist', [AdminController::class, 'index'])->name('dashboard.adminlist');

    Route::post('/dashboard/admin/create', [AdminController::class, 'create'])->name('dashboard.admin.create');

    Route::post('/editadmin/{id}', [AdminController::class, 'edit'])->name('admin.edit');

    Route::get('/deleteadmin/{id}', [AdminController::class, 'delete'])->name('admin.delete');



    // Expense Route

    Route::get('/dashboard/expense', [ExpenseController::class, 'index'])->name('expense');

    Route::post('/dashboard/expense/store', [ExpenseController::class, 'store'])->name('expense.store');

    Route::post('/dashboard/expense/update/{id}', [ExpenseController::class, 'update'])->name('expense.update');

    Route::get('/dashboard/expense/delete/{id}', [ExpenseController::class, 'delete'])->name('expense.delete');



    // Package Route

    Route::get('/dashboard/package', [PackageController::class, 'index'])->name('package');

    Route::post('/dashboard/package/store', [PackageController::class, 'store'])->name('package.store');

    Route::post('/dashboard/package/update', [PackageController::class, 'update'])->name('package.update');

    Route::get('/dashboard/package/inactive/{id}', [PackageController::class, 'inactive'])->name('package.inactive');

    Route::get('/dashboard/package/active/{id}', [PackageController::class, 'active'])->name('package.active');



    // Admin Customer Routes

    Route::get('/customer/alllist', [AdminCustomerController::class, 'customerall'])->name('customer.alllist');

    Route::get('/customer/newlist', [AdminCustomerController::class, 'customernewlist'])->name('customer.newlist');

    Route::get('/customer/activelist', [AdminCustomerController::class, 'customeractivelist'])->name('customer.activelist');

    Route::get('/customer/inactivelist', [AdminCustomerController::class, 'customerinactivelist'])->name('customer.inactivelist');




    // due customer list
    Route::get('/customer/duelist', [AdminCustomerController::class, 'customerduelist'])->name('customer.duelist');

    Route::post('/customer/due', [AdminCustomerController::class, 'customerdue'])->name('customer.due');

    // Route::post('/customer/updateMonths', 'AdminCustomerController@updateMonths')->name('customer.updateMonths');


    Route::post('/customer/register', [AdminCustomerController::class, 'customerregister'])->name('customer.register');

    Route::get('/customer/active/{id}', [AdminCustomerController::class, 'customeractive'])->name('customer.active');

    Route::post('/customer/inactive', [AdminCustomerController::class, 'customerinactive'])->name('customer.inactive');

    Route::get('/customer/delete/{id}', [AdminCustomerController::class, 'customerdelete'])->name('customer.delete');

    Route::post('/customer/change/package', [AdminCustomerController::class, 'changepackage'])->name('customer.change.package');

    // rimonnahid update

    Route::post('/customer-update/{customer}', [AdminCustomerController::class, 'customerUpdate'])->name('customer.update');

    // admin bill


    // update months 

    Route::post('/customer-month-update/{customer}', [AdminCustomerController::class, 'updateMonths'])->name('customer.updateMonths');



    // Withdraw Route

    Route::get('/dashboard/withdraw', [WithdrawController::class, 'index'])->name('withdraw');

    Route::post('/dashboard/withdraw/store', [WithdrawController::class, 'store'])->name('withdraw.store');

    Route::post('/dashboard/withdraw/update', [WithdrawController::class, 'update'])->name('withdraw.update');



    // Invioce Route

    Route::get('/invioce', [InvioceModelController::class, 'index'])->name('invioce');

    Route::get('/single/invioce/{id}', [InvioceModelController::class, 'singleinvioce'])->name('singleinvioce');


    // admin bill

    // Admin Bill Routes

    Route::get('/admin/bills', [AdminBillController::class, 'adminbillall'])->name('admin.bills');
    
    Route::get('/admin/bills/create', [AdminBillController::class, 'create'])->name('admin.bills.create');
    Route::post('/admin/bills/store', [AdminBillController::class, 'store'])->name('admin.bills.store');
    Route::get('/admin/bills/edit/{id}', [AdminBillController::class, 'edit'])->name('admin.bills.edit');
    Route::post('/admin/bills/update/{id}', [AdminBillController::class, 'update'])->name('admin.bills.update');
    Route::get('/admin/bills/delete/{id}', [AdminBillController::class, 'delete'])->name('admin.bills.delete');


    // Company Bill Routes

    Route::get('/company/bills', [CompanyBillModelController::class, 'index'])->name('company.bills');
    Route::get('/company/bills/create', [CompanyBillModelController::class, 'create'])->name('company.bills.create');
    Route::post('/company/bills/store', [CompanyBillModelController::class, 'store'])->name('company.bills.store');
    Route::get('/company/bills/edit/{id}', [CompanyBillModelController::class, 'edit'])->name('company.bills.edit');
    Route::post('/company/bills/update/{id}', [CompanyBillModelController::class, 'update'])->name('company.bills.update');
    Route::get('/company/bills/delete/{id}', [CompanyBillModelController::class, 'delete'])->name('company.bills.delete');

});


// Customer Route

Route::get('/registration/form', [CustomerController::class, 'index'])->name('registration.form');

Route::post('/customer/form/post', [CustomerController::class, 'store'])->name('customer.form.post');
