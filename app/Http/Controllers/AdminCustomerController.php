<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\User;

use App\Models\InvioceModel;

use App\Models\PackageModel;

use Illuminate\Http\Request;

use App\Models\CustomerModel;
use App\Models\BroadbandCompanyBill;

use Illuminate\Support\Facades\DB; // Import the DB facade


// admin bill model

use App\Models\AdminBillModel;

// comany bill model



use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Psy\Readline\Hoa\Console;

class AdminCustomerController extends Controller

{

    public function __construct()

    {

        $this->middleware('customerrules');
    }



    public function customerall()
    {

        return view('pages.admin.customerlistall', [

            'customers' => CustomerModel::where('status', '!=', 0)->get(),

            'heading' => "ALl Customer List"

        ]);
    }

    public function customeractivelist()
    {

        return view('pages.admin.customerlistactive', [

            'customers' => CustomerModel::where('status', 1)->get(),

            'heading' => "Active Customer List"

        ]);
    }

    public function customerinactivelist()
    {
        return view('pages.admin.customerlistinactive', [
            'customers' => CustomerModel::where('status', 2)->get(),

            'heading' => "Inactive Customer List"

        ]);
    }

    public function customernewlist()
    {

        return view('pages.admin.customerlistnew', [
            'customers' => CustomerModel::where('status', 0)->get(),

            'heading' => "New Request Customer List"
        ]);
    }

    // due customer list

    public function customerduelist()
    {

        return view('pages.admin.customerlistdue', [

            'customers' => CustomerModel::where('payment_status', 'due')->get(),

            'heading' => "Due Customer List"
        ]);
    }

    public function customerregister(Request $request)

    {

        $request->validate([

            'name' => 'required',

            'phone' => 'required',

            'net_id' => ['required', 'unique:users', 'max:255'],

            'password' => 'required',

        ]);

        $customer = CustomerModel::where('id', $request->id)->first();

        $package = PackageModel::where('id', $customer->package_id)->first();

        $user_id = User::create([

            'name' => $request->name,

            'phone' => $request->phone,

            'net_id' => $request->net_id,

            'password' => Hash::make($request->password),

        ]);

        CustomerModel::where('id', $request->id)->update([

            'user_id' => $user_id->id,

            'name' => $request->name,

            'email' => $request->email,

            'phone' => $request->phone,

            'nid' => $request->nid,

            'pon_mac' => $request->pon_mac,

            'route_mac' => $request->route_mac,

            'address' => $request->address,

            'active_date' => Carbon::now(),

            'packeg_amount' => $request->amount,

            'payment_status' => 'paid',

            'last_payment_date' => Carbon::now(),

            'status' => 1,

        ]);



        InvioceModel::create([

            'invoice_no' => "ASF-" . time(),

            'package_title' => $package->package_title,

            'package_speed' => $package->package_speed,

            'package_price' => $request->amount,

            'created_by' => Auth::id(),

            'cust_id' => $request->id,

        ]);



        //Start Mobile Sms Notification

        $to = $request->phone;

        $token = "ef5ffbea48fcdbb315bffd9d56f8c077";

        $message = "Congratulation " . $request->name . "!! Welcome to our company." . "\n" . "your Id : " . $request->net_id . "\n" . "Your password : " . $request->password;

        $url = "http://api.greenweb.com.bd/api.php?json";


        $data = array(

            'to' => "$to",

            'message' => "$message",

            'token' => "$token"

        ); // Add parameters in key value

        $ch = curl_init(); // Initialize cURL

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_ENCODING, '');

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $smsresult = curl_exec($ch);

        return redirect()->route('customer.activelist')->with('succsess', 'add successfully');
    }




    public function customeractive($id)

    {

        CustomerModel::where('id', $id)->update([

            'status' => 2,

        ]);

        InvioceModel::where('cust_id', $id)->update([

            'status' => 0,

        ]);

        return back()->with('succsess', 'add successfully');
    }



    public function customerinactive(Request $request)

    {

        $cust = CustomerModel::where('id', $request->cust_id)->first();



        $package = PackageModel::where('id', $cust->package_id)->first();



        CustomerModel::where('id', $request->cust_id)->update([

            'status' => 1,
            'payment_status' => 'paid',
            'last_payment_date' => Carbon::now(),

        ]);

        InvioceModel::create([

            'invoice_no' => "SST-" . time(),

            'package_title' => $package->package_title,

            'package_speed' => $package->package_speed,

            'package_price' => $request->amount,

            'created_by' => Auth::id(),

            'cust_id' => $request->cust_id,

            'status' => 1,

        ]);

        // after payment devide the bill amount 60% for company and 40% for admin

        $totalAmount = $request->amount;
        $adminAmount = $totalAmount * 0.4; // 40% to the admin

        AdminBillModel::create([
            'name' => $cust->name,
            'user_id' => $cust->user_id,
            'package_id' => $cust->package_id,
            'months' => json_encode($cust->months),
            'amounts' => $adminAmount,
            'status' => 1,
            'paid' => 1,
        ]);


        //Start Mobile Sms Notification

        $to = $cust->phone;

        $token = "ef5ffbea48fcdbb315bffd9d56f8c077";

        $message = "Congratulation " . $cust->name . "!! Welcome to our company." . "\n" . "your account is activated";

        $url = "http://api.greenweb.com.bd/api.php?json";

        $data = array(

            'to' => "$to",

            'message' => "$message",

            'token' => "$token"

        ); // Add parameters in key value

        $ch = curl_init(); // Initialize cURL

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_ENCODING, '');

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $smsresult = curl_exec($ch);



        //Result

        // echo $smsresult;

        //Error Display

        // echo curl_error($ch);



        //End Mobile Sms Notification



        return back()->with('succsess', 'add successfully');
    }

    // update some code for due  customer here customer is not payd bill geter then 30 days then customer status is 3

    public function customerdue(Request $request)
    {
        $cust = CustomerModel::where('id', $request->cust_id)->first();

        // Check if the customer has an active invoice
        $activeInvoice = InvioceModel::where('cust_id', $cust->id)
            ->where('status', 1) // Assuming 1 is the status for an active invoice
            ->first();

        if ($activeInvoice) {
            // Get the due date of the active invoice
            $dueDate = $activeInvoice->created_at->addDays(30); // Assuming due date is 60 days after invoice creation

            // Check if the due date is in the past
            if (Carbon::now()->greaterThan($dueDate)) {
                // Update the customer's status to 3 (for overdue)
                $cust->update(['status' => 3]);
            }
        }

        return back()->with('success', 'Customer status updated successfully.');
    }


    public function customerdelete($id)

    {

        CustomerModel::where('id', $id)->delete();

        return back()->with('succsess', 'Delete successfully');
    }

    public function changepackage(Request $request)
    {
        CustomerModel::where('id', $request->cust_id)->update([
            'package_id' => $request->package_id,
        ]);

        return back()->with('succsess', 'Change successfully');
    }

    public function customerUpdate($id, Request $request)
    {
        $customer = CustomerModel::where('id', $id)->first();

        $customer->update([

            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nid' => $request->nid,
            'pon_mac' => $request->pon_mac,
            'route_mac' => $request->route_mac,
            'address' => $request->address,
            'months' =>  $request->months,
            'bill_amount' => $request->bill_amount,
        ]);
        return 'success';
    }
    public function payNowWithMonth($id, Request $request)
    {
        // Get the customer
        $customer = CustomerModel::where('id', $id)->first();

        // Calculate the amounts for the broadband company and admin
        $totalAmount = $request->bill_amount;
        $broadbandCompanyAmount = $totalAmount * 0.6; // 60% to the broadband company
        $adminAmount = $totalAmount * 0.4; // 40% to the admin

        // Decode the existing months data from JSON
        $existingMonths = json_decode($customer->months, true);
        $existingMonths = $existingMonths ?? [];

        $newMonths = $request->months;
        $mergedMonths = array_merge($existingMonths, $newMonths);


        $prevBillAmount = $customer->bill_amount;
        $margedBillAmount = $prevBillAmount + $request->bill_amount;

        // Update the customer record with the merged months data
        $customer->update([
            'months' => json_encode($mergedMonths),
            'bill_amount' => $margedBillAmount,
            'last_payment_date' => Carbon::now(),
            'payment_status' => 'paid',
        ]);

        AdminBillModel::create([
            'name' => $request->name,
            'user_id' => $customer->user_id,
            'package_id' => $customer->package_id,
            'months' => json_encode($newMonths),
            'amounts' => $adminAmount,
            'status' => 1,
            'paid' => 1,
        ]);

        return back()->with('succsess', 'Payment successfully');
    }




    public function customerdueupdate(Request $request)
    {
        $customer = CustomerModel::where('id', $request->cust_id)->first();

        $customer->update([
            'months' => json_encode($request->months),
        ]);

        return back()->with('succsess', 'Payment successfully');
    }
}
