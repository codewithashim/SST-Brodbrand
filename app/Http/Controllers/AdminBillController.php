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
        // Validate the request data
        $request->validate([
            'user_id' => 'required|integer',
            'package_id' => 'required|integer',
            'months' => 'required|string',
            'amounts' => 'required|numeric',
        ]);

        // Update the database record
        AdminBillModel::where('id', $id)->update([
            'user_id' => $request->input('user_id'),
            'package_id' => $request->input('package_id'),
            'months' => $request->input('months'),
            'amounts' => $request->input('amounts'),
        ]);

        return redirect()->route('adminbill')->with('success', 'Update successful');
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
            'amounts' => 'required',
            'status' => 'required',
            'paid' => 'required',
            'due_date' => 'required'
        ]);
    }
}
