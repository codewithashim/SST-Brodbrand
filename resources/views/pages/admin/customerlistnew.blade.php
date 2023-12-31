@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box table-responsive">
                <div class="d-flex justify-content-between">
                    <h1 class="m-t-0 w-100 text-center"><b>{{ $heading }}</b></h1>
                </div>

                <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="align-middle text-center">Sl.</th>
                            <th class="align-middle text-center">Name</th>
                            <th class="align-middle text-center">Email</th>
                            <th class="align-middle text-center">Phone</th>
                            <th class="align-middle text-center">Status</th>
                            <th class="align-middle text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td class="align-middle text-center">{{ ++$loop->index }}</td>
                                <td class="align-middle text-center">{{ $customer->name }}</td>
                                <td class="align-middle text-center">{{ $customer->email }}</td>
                                <td class="align-middle text-center">{{ $customer->phone }}</td>
                                <td class="align-middle text-center">Inactive</td>

                                <td class="align-middle text-center">
                                    <a class="btn btn-sm btn-primary" href="{{ route('customer.delete',$customer->id) }}">Delete</a>
                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#ActiveModel{{ $customer->id }}">Active</a>
                                </td>
                            </tr>
                            <!-- Edit modal content -->
                                <div id="ActiveModel{{ $customer->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">User Registration</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
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
                                                <form method="POST" action="{{ route('customer.register') }}" data-parsley-validate novalidate>
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $customer->id }}">
                                                    <div class="col col-sm-12 col-md-6">
                                                        <div class="form-group">
                                                            <label>Client Name :</label>
                                                            <input type="text" name="name" parsley-trigger="change" required
                                                            placeholder="Enter User name" class="form-control" value="{{ $customer->name }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Client Email :</label>
                                                            <input type="email" name="email" parsley-trigger="change" required
                                                            placeholder="Enter User Email" class="form-control" value="{{ $customer->email }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Client Phone :</label>
                                                            <input type="text" name="phone" parsley-trigger="change" required
                                                            placeholder="Enter phone" class="form-control" value="{{ $customer->phone }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col col-sm-12 col-md-6">
                                                        <div class="form-group">
                                                            <label>Client NID :</label>
                                                            <input type="text" name="nid" parsley-trigger="change" required
                                                            placeholder="Enter nid" class="form-control" value="{{ $customer->nid }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Client PON MAC :</label>
                                                            <input type="text" name="pon_mac" parsley-trigger="change" required
                                                            placeholder="Enter Pon Mac" class="form-control" value="{{ $customer->pon_mac }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Client Route MAC :</label>
                                                            <input type="text" name="route_mac" parsley-trigger="change" required
                                                            placeholder="Enter Route Mac" class="form-control" value="{{ $customer->route_mac }}">
                                                        </div>
                                                    </div>

                                                    <div class="col col-sm-12 col-md-6">
                                                        <div class="form-group">
                                                            <label>Client Address :</label>
                                                            <textarea name="address" class="form-control h-100 w-100" rows="10" cols="50">{{ $customer->address }}</textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="border border-danger p-4">
                                                    <h1 class="text-center">Give an ID And Demo Password</h1>

                                                            <!-- <input type="hidden" name="id" value="{{ $customer->id }}">
                                                            <input type="hidden" name="name" value="{{ $customer->name }}">
                                                            <input type="hidden" name="phone" value="{{ $customer->phone }}"> -->
                                                            <div class="form-group">
                                                                <label>User Id*</label>
                                                                <input type="text" name="net_id" parsley-trigger="change" required
                                                                placeholder="Enter User Id" class="form-control" value="">
                                                            </div>
                                                            @error('net_id')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                            <div class="form-group">
                                                                <label>User password*</label>
                                                                <input type="password" name="password" parsley-trigger="change" required
                                                                placeholder="Enter User password" class="form-control" value="">
                                                            </div>
                                                            @error('password')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                            <div class="form-group">
                                                                <label>Pay Amount*</label>
                                                                <input type="number" name="amount" parsley-trigger="change" required
                                                                placeholder="Enter User Amount" class="form-control" value="">
                                                            </div>
                                                            @error('amount')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                            <!-- /.modal -->
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
