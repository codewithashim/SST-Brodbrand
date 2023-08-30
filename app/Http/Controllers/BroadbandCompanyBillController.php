<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BroadbandCompanyBill;

class BroadbandCompanyBillController extends Controller
{
    public function __construct()
    {
        $this->middleware('customerrules');
    }

    public function index()
    {
        return view('pages.admin.companybill', [
            'companybills' => BroadbandCompanyBill::all(),
            'heading' => 'Advance Company Bill List'

        ]);
    }

    public function store(Request $request)
    {
        BroadbandCompanyBill::create($this->validation());
        return redirect()->route('companybill')->with('succsess', 'add successfully');
    }

    public function update($id, Request $request)
    {
        // Validate the request data
        $request->validate([
            'months' => 'required|string',
            'total_amount' => 'required|numeric',
            'billing_date' => 'required|date',
        ]);

        // Update the database record
        BroadbandCompanyBill::where('id', $id)->update([
            'months' => $request->months,
            'total_amount' => $request->total_amount,
            'billing_date' => $request->billing_date,
        ]);

        return redirect()->route('companybill')->with('success', 'Update successful');
    }

    public function delete($id)
    {
        BroadbandCompanyBill::find($id)->Delete();
        return redirect()->route('companybill')->with('succsessdelete', 'delete successfully');
    }


    public function validation()
    {
        return request()->validate([
            'user_id' => 'required',
            'package_id' => 'required',
            'months' => 'required',
            'amount' => 'required',
            'status' => 'required',
            'paid' => 'required',
            'due_date' => 'required'
        ]);
    }
}
