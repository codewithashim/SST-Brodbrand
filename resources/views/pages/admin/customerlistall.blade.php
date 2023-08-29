@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">

        @if(session('success'))
        <div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="font-35 text-white"><i class='bx bxs-check-circle'></i>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-white">Success</h6>
                    <div class="text-white">{{ session('success') }}</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('wrong'))

        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="font-35 text-white"><i class='bx bxs-check-circle'></i>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-white">Success</h6>
                    <div class="text-white">{{ session('wrong') }}</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    </div>
</div>

<div class="row">

    <div class="col-12">

        <div class="card-box table-responsive">

            <div class="d-flex justify-content-between">

                <h1 class="m-t-0 w-100 text-center"><b>{{ $heading }}</b></h1>

            </div>


            <table id="datatable-buttons" class="table table-bordered" cellspacing="0" width="100%">
                <thead>

                    <tr>

                        <th class="align-middle text-center">Sl.</th>

                        <th class="align-middle text-center">Name</th>

                        <th class="align-middle text-center">Email</th>

                        <th class="align-middle text-center">Phone</th>

                        <th class="align-middle text-center">User ID</th>

                        <th class="align-middle text-center">Status</th>

                        <th class="align-middle text-center">Bill Amount</th>

                        <th class="align-middle text-center">Month</th>


                        <th class="align-middle text-center">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($customers as $customer)

                    <tr class="{{ (($customer->status == 1) ? 'bg-success' : 'bg-danger') }}">

                        <td class="align-middle text-center">{{ ++$loop->index }}</td>

                        <td class="align-middle text-center">{{ $customer->name }}</td>

                        <td class="align-middle text-center">{{ $customer->email }}</td>

                        <td class="align-middle text-center">{{ $customer->phone }}</td>

                        <td class="align-middle text-center"></td>

                        <td class="align-middle text-center">

                            @if ($customer->status == 1)

                            Active

                            @else

                            Inactive

                            @endif

                        </td>

                        <td class="align-middle text-center">{{ $customer->bill_amount }}</td>

                        <td class="align-middle text-center">
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#view{{ $customer->user_id }}">Month</button>
                        </td>


                        <td class="align-middle text-center">
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#view{{ $customer->id }}">View</button>
                            <a href="{{ route('customer.delete',$customer->id) }}" id="delete" class="btn btn-sm btn-danger">Delete</a>
                        </td>

                    </tr>
                    <!-- Month Modal -->

                    <!-- Add this code to your Blade view file -->
                    <div class="modal fade" id="view{{ $customer->user_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Select Months for {{ $customer->name }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @csrf
                                <div class="modal-body">
                                    <form action="{{ route('customer.payNow',$customer->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <!-- Add payment amount input field -->
                                        <div class="form-group">
                                            <label>Payment Amount</label>
                                            <input type="number" name="bill_amount" class="form-control" value="{{ $customer->bill_amount }}" id="payment_amount" placeholder="Enter Payment Amount" required>
                                        </div>

                                        <input type="hidden" name="customer_id" value="{{ $customer->user_id }}">
                                        <div class="form-group">
                                            <label>Select Months</label>
                                            @php
                                            $currentYear = date('Y');
                                            $months = [];
                                            for ($i = 1; $i <= 12; $i++) { $timestamp=mktime(0, 0, 0, $i, 1, $currentYear); $monthName=date('F', $timestamp); $months[$i]=$monthName; } @endphp @foreach ($months as $key=> $month)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="months[]" value="{{  $month }}" id="month{{ $key }}">
                                                    <label class="form-check-label" for="month{{ $key }}">
                                                        {{ $month }}
                                                    </label>
                                                </div>
                                                @endforeach
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            Pay Now
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Edit modal content -->

                    <div id="view{{ $customer->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                        <div class="modal-dialog modal-lg">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h4 class="modal-title" id="myModalLabel">User Registration</h4>

                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                                </div>
                                <form action="{{ route('customer.update',$customer->id) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">


                                        <div class="row">

                                            <div class="col col-sm-12 col-md-6">

                                                @php

                                                $data = customer_package($customer->package_id)

                                                @endphp

                                                <div class="card m-b-20 card-inverse text-white" style="background-color: #333; border-color: #333;">

                                                    <div class="card-body">

                                                        <h3 class="card-title">{{ $data->package_title }}</h3>

                                                        <h5 class="card-title">{{ $data->package_speed }}</h5>

                                                        <p class="card-text">{{ $data->package_discription }}</p>

                                                        <h1 class="card-title">৳{{ $data->package_price }}</h1>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col col-sm-12 col-md-6">

                                                <div class="form-group">

                                                    <label>Client Name :</label>

                                                    <input class="form-control" name="name" value="{{ $customer->name }}">

                                                </div>

                                                <div class="form-group">

                                                    <label>Client Email :</label>

                                                    <input class="form-control" name="email" value="{{ $customer->email }}">

                                                </div>

                                                <div class="form-group">

                                                    <label>Client Phone :</label>

                                                    <input class="form-control" name="phone" value="{{ $customer->phone }}">

                                                </div>

                                            </div>

                                        </div>
                                        <div class="row">

                                            <div class="col col-sm-12 col-md-6">

                                                <div class="form-group">

                                                    <label>Client NID :</label>

                                                    <input class="form-control" name="nid" value="{{ $customer->nid }}">

                                                </div>

                                                <div class="form-group">

                                                    <label>Client PON MAC :</label>

                                                    <input class="form-control" name="pon_mac" value="{{ $customer->pon_mac }}">

                                                </div>

                                                <div class="form-group">

                                                    <label>Client Route MAC :</label>

                                                    <input class="form-control" name="route_mac" value="{{ $customer->route_mac }}">

                                                </div>
                                            </div>
                                            <div class="col col-sm-12 col-md-6">

                                                <div class="form-group">

                                                    <label>Client Route MAC :</label>

                                                    <textarea class="form-control h-100 w-100" rows="5" cols="50" name="address">

                                                    {{ $customer->address }}

                                                    </textarea>

                                                </div>

                                                <div class="form-group">

                                                    <label>Amount :</label>

                                                    <input class="form-control" name="bill_amount" value="{{ $customer->bill_amount }}">

                                                </div>

                                                <div class="form-group">

                                                    <label>User Id*</label>

                                                    <input class="form-control" value="{{ get_customer_netid($customer->user_id)->net_id }}">

                                                </div>

                                                <div class="form-group">

                                                    <label>Months :</label>

                                                    <textarea class="form-control h-100 w-100" rows="5" cols="50" name="months">

                                                    {{ $customer->months }}

                                                    </textarea>

                                                </div>

                                            </div>
                                            <button class="btn btn-success">Update Customer</button>
                                        </div>

                                    </div>
                                </form>

                            </div><!-- /.modal-content -->

                        </div><!-- /.modal-dialog -->

                    </div>

                    <!-- /.modal -->

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>
    <!-- Add this script at the bottom of your Blade view -->
    <script>
        // Get all the checkboxes with the name "months"
        const checkboxes = document.querySelectorAll('input[name="months[]"]');

        // Add an event listener to the form for submission
        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting

            const selectedMonths = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.nextSibling.textContent.trim());

            const paymentAmount = document.querySelector('input[name="payment_amount"]').value;

            console.log('Selected Months:', selectedMonths);
            console.log('Payment Amount:', paymentAmount);

            // Now you can submit the form using JavaScript if needed
            // Uncomment the following line if you want to submit the form
            // event.target.submit();
        });
    </script>


</div>

@endsection