<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\CustomerModel;
use App\Models\BroadbandCompanyBill;

class GenerateCompanyBills extends Command
{
    protected $signature = 'generate:company-bills';
    protected $description = 'Generate company bills for all customers';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $billingDate = Carbon::now();
        $totalBillAmount = 0;
        $companyPercentage = 0.6; // 60% for admin
        $months = $billingDate->format('F Y');
        $customers = CustomerModel::all();


        foreach ($customers as $customer) {
            $packageAmount = $customer->packeg_amount;
            $billAmount = $packageAmount;
            $totalBillAmount += $billAmount;
        }

        // Calculate the company's share

        $companyShare = $totalBillAmount * $companyPercentage;

        BroadbandCompanyBill::create([
            'total_amount' => $companyShare,
            'months' => $months,
            'billing_date' => $billingDate,
            'amounts' =>  $companyShare,
        ]);

        $this->info('Company billing record created successfully:');
        $this->info('Total Bill Amount: ' . $companyShare);
        $this->info('Billing Date: ' . $billingDate->toDateString());
        $this->info('Months: ' . $months);
    }
}
