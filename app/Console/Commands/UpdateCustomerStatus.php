<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\CustomerModel;

class UpdateCustomerStatus extends Command
{
    protected $signature = 'update:customer-status';
    protected $description = 'Update customer payment statuses';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get the current date
        $currentDate = Carbon::now();

        // Calculate the date 30 days ago
        $thirtyDaysAgo = $currentDate->subDays(30);

        // Retrieve customers who have not paid in the last 30 days
        $dueCustomers = CustomerModel::where('payment_status', 'paid')
            ->whereDate('last_payment_date', '<=', $thirtyDaysAgo)
            ->get();

        foreach ($dueCustomers as $customer) {
            $customer->payment_status = 'due';
            $customer->save();
        }

        // Optionally, you can log or return the results
        $this->info('Updated ' . count($dueCustomers) . ' customer statuses to "due".');
    }
}
