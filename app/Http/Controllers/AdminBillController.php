<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminBillModel;

class AdminBillController extends Controller
{
    public function index()
    {
        $adminBillModes = AdminBillModel::all();
        return view('pages.admin.adminbill', compact('adminBillModes'));
    }

    public function adminbillall()
    {
        return view('pages.admin.adminbill', [
            'customers' => AdminBillModel::where('status', '!=', 0)->get(),

            'heading' => "ALl Customer List"

        ]);
    }


    public function create()
    {
        // Show the form to create a new admin bill mode
        return view('admin_bill_modes.create');
    }

    public function store(Request $request)
    {
        // Validate and store a new admin bill mode
        $request->validate([
            'user_id' => 'required',
            'package_id' => 'required',
            'months' => 'required',
            'amount' => 'required',
            'status' => 'required',
            'paid' => 'required',
        ]);

        AdminBillModel::create($request->all());

        return redirect()->route('adminBillModes.index')
            ->with('success', 'Admin bill mode created successfully.');
    }

    public function show(AdminBillModel $adminBillMode)
    {
        // Show the details of a specific admin bill mode
        return view('admin_bill_modes.show', compact('adminBillMode'));
    }

    public function edit(AdminBillModel $adminBillMode)
    {
        // Show the form to edit a specific admin bill mode
        return view('admin_bill_modes.edit', compact('adminBillMode'));
    }

    public function update(Request $request, AdminBillModel $adminBillMode)
    {
        // Validate and update a specific admin bill mode
        $request->validate([
            'user_id' => 'required',
            'package_id' => 'required',
            'months' => 'required',
            'amount' => 'required',
            'status' => 'required',
            'paid' => 'required',
        ]);

        $adminBillMode->update($request->all());

        return redirect()->route('adminBillModes.index')
            ->with('success', 'Admin bill mode updated successfully.');
    }

    public function destroy(AdminBillModel $adminBillMode)
    {
        // Delete a specific admin bill mode
        $adminBillMode->delete();

        return redirect()->route('adminBillModes.index')
            ->with('success', 'Admin bill mode deleted successfully.');
    }
}
