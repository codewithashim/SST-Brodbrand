<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyBillModel;

class CompanyBillModelController extends Controller
{
    public function index()
    {
        // Retrieve a list of company bill models
        $companyBillModels = CompanyBillModel::all();
        return view('company_bill_models.index', compact('companyBillModels'));
    }

    public function create()
    {
        // Show the form to create a new company bill model
        return view('company_bill_models.create');
    }

    public function store(Request $request)
    {
        // Validate and store a new company bill model
        $request->validate([
            'user_id' => 'required',
            'package_id' => 'required',
            'months' => 'required',
            'amount' => 'required',
            'status' => 'required',
            'paid' => 'required',
        ]);

        CompanyBillModel::create($request->all());

        return redirect()->route('companyBillModels.index')
            ->with('success', 'Company bill model created successfully.');
    }

    public function show(CompanyBillModel $companyBillModel)
    {
        // Show the details of a specific company bill model
        return view('company_bill_models.show', compact('companyBillModel'));
    }

    public function edit(CompanyBillModel $companyBillModel)
    {
        // Show the form to edit a specific company bill model
        return view('company_bill_models.edit', compact('companyBillModel'));
    }

    public function update(Request $request, CompanyBillModel $companyBillModel)
    {
        // Validate and update a specific company bill model
        $request->validate([
            'user_id' => 'required',
            'package_id' => 'required',
            'months' => 'required',
            'amount' => 'required',
            'status' => 'required',
            'paid' => 'required',
        ]);

        $companyBillModel->update($request->all());

        return redirect()->route('companyBillModels.index')
            ->with('success', 'Company bill model updated successfully.');
    }

    public function destroy(CompanyBillModel $companyBillModel)
    {
        // Delete a specific company bill model
        $companyBillModel->delete();

        return redirect()->route('companyBillModels.index')
            ->with('success', 'Company bill model deleted successfully.');
    }
}
