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
            'heading' => 'All Company Bill List'

        ]);
    }

    public function store(Request $request)
    {
        BroadbandCompanyBill::create($this->validation());
        return redirect()->route('companybill')->with('succsess', 'add successfully');
    }

    public function update($id, Request $request)
    {
        BroadbandCompanyBill::where('id', $id)->update([
            'name' => 'required',
            'user_id' => 'required',
            'package_id' => 'required',
            'months' => 'required',
            'amount' => 'required',
            'status' => 'required',
            'paid' => 'required',
            'due_date' => 'required'
        ]);
        return redirect()->route('companybill')->with('succsessedit', 'update successfully');
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
