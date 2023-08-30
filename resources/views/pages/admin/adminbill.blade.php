@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <div class="d-flex justify-content-between">
                <h1 class="m-t-0 w-100 text-center"><b>{{ $heading }}</b></h1>
            </div>

            @if($adminbills->isEmpty())
            <p class="text-center">No Bill Available.</p>
            @else
            <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="align-middle text-center">Sl.</th>
                        <th class="align-middle text-center">User Id</th>
                        <th class="align-middle text-center">Packeg Id</th>
                        <th class="align-middle text-center">Amount</th>
                        <th class="align-middle text-center">Months</th>
                        <th class="align-middle text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($adminbills as $adminbill)
                    <tr>
                        <td class="align-middle text-center">{{ ++$loop->index }}</td>
                        <td class="align-middle text-center">{{get_customer_netid($adminbill->user_id)->net_id }}</td>
                        <td class="align-middle text-center">{{ $adminbill->package_id }}</td>
                        <td class="align-middle text-center">{{ $adminbill->amounts }}</td>

                        <td class="align-middle text-center">
                            @php
                            $monthsArray = json_decode($adminbill->months);
                            @endphp
                            @foreach((array) $monthsArray as $month)
                            <span>
                                {{ $month }} .
                            </span>
                            @endforeach
                        </td>

                        <td class="align-middle text-center" style="display: flex; gap: 1rem;">
                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{$adminbill->id}}">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$adminbill->id}}">Delete</a>
                        </td>

                        <!-- Edit Modal -->
                        <div id="editModal{{$adminbill->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$adminbill->id}}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{$adminbill->id}}">Edit Bill</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div>
                                        <p>
                                            {{get_customer_netid($adminbill->user_id)->net_id }} User Bill
                                        </p>
                                    </div>

                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('adminbill.update', $adminbill->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                                            @csrf
                                            @method('POST')

                                            <div class="form-group">
                                                <label for="user_id">User ID</label>
                                                <input type="text" class="form-control" id="user_id" name="user_id" value="{{$adminbill->user_id}}" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label for="package_id">Package ID</label>
                                                <input type="text" class="form-control" id="package_id" name="package_id" value="{{$adminbill->package_id}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="amounts">Amount</label>
                                                <input type="text" class="form-control" id="amounts" name="amounts" value="{{$adminbill->amounts}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="months">Months</label>
                                                <input type="text" class="form-control" id="months" name="months" value="{{$adminbill->months}}">
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->

                        <div id="deleteModal{{$adminbill->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{$adminbill->id}}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-danger" id="deleteModalLabel{{$adminbill->id}}">Delete Bill</h5>
                                        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div>
                                        <p>
                                            Are you sure you want to delete this bill?
                                        </p>
                                    </div>

                                    <div class="modal-footer">
                                        <form method="GET" action="{{ route('adminbill.delete', $adminbill->id) }}">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>

                                </div>
                            </div>

                    </tr>
                    @endforeach
                </tbody>
                <tr>
                    <td class="align-middle text-center" colspan="3">Total Amount</td>
                    <td class="align-middle text-center">{{ $adminbills->sum('amounts') }}</td>
                    <td class="align-middle text-center" colspan="2"></td>
                </tr>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection