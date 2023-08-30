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
                        <th class="align-middle text-center">Months</th>
                        <th class="align-middle text-center">Amount</th>
                        <th class="align-middle text-center">Billing Date</th>
                        <th class="align-middle text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companybills as $companybill)
                    <tr>
                        <td class="align-middle text-center">{{ ++$loop->index }}</td>
                        <td class="align-middle text-center">{{ $companybill->months }}</td>
                        <td class="align-middle text-center">{{ $companybill->	total_amount }}</td>
                        <td class="align-middle text-center">{{ $companybill->billing_date	 }}</td>

                        <td class="align-middle text-center" style="display: flex; gap: 1rem;">
                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{$companybill->id}}">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$companybill->id}}">Delete</a>
                        </td>
                    </tr>

                    <!-- Edit Modal -->

                    <!-- Edit Modal -->
                    <div id="editModal{{$companybill->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$companybill->id}}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{$companybill->id}}">Edit Company Bill</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Edit form -->
                                    <form action="{{ route('companybill.update', $companybill->id) }}" method="POST">
                                        @csrf
                                        <!-- Input fields for editing -->
                                        <div class="form-group">
                                            <label for="months">Months</label>
                                            <input type="text" class="form-control" id="months" name="months" value="{{ $companybill->months }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="total_amount">Total Amount</label>
                                            <input type="text" class="form-control" id="total_amount" name="total_amount" value="{{ $companybill->total_amount }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="billing_date">Billing Date</label>
                                            <input type="text" class="form-control" id="billing_date" name="billing_date" value="{{ $companybill->billing_date }}">
                                        </div>

                                        <!-- Add more input fields as needed -->

                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </form>
                                    <!-- End of Edit form -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Edit Modal -->


                    <!-- Delete Modal -->
                    <div id="deleteModal{{$companybill->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{$companybill->id}}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{$companybill->id}}">Delete Company Bill</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this company bill?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <form action="{{ route('companybill.delete', $companybill->id) }}" method="GET">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach

                </tbody>
                <tr>
                    <td class="align-middle text-center" colspan="2">Total Amount</td>
                    <td class="align-middle text-center">{{ $companybills->sum('total_amount') }}</td>
                    <td class="align-middle text-center" colspan="2"></td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection