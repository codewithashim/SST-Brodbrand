<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AdminBillModel;

class AdminBillController extends Controller
{

    public function __construct()
    {
        $this->middleware('customerrules');
    }

    public function index()
    {
        return view('pages.admin.adminbill', [
            'adminbills' => AdminBillModel::all(),
            'heading' => 'All Admin Bill List'

        ]);
    }

    public function store(Request $request)
    {
        AdminBillModel::create($this->validation());
        return redirect()->route('adminbill')->with('succsess', 'add successfully');
    }

    public function update($id, Request $request)
    {
        AdminBillModel::where('id', $id)->update([
            'user_id' => 'required',
            'package_id' => 'required',
            'months' => 'required',
            'amount' => 'required',
            'status' => 'required',
            'paid' => 'required',
            'due_date' => 'required'
        ]);
        return redirect()->route('adminbill')->with('succsessedit', 'update successfully');
    }

    public function delete($id)
    {
        AdminBillModel::find($id)->Delete();
        return redirect()->route('adminbill')->with('succsessdelete', 'delete successfully');
    }


    public function validation()
    {
        return request()->validate([
            'name' => 'required',
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
