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
                            <th class="align-middle text-center">Name</th>
                            <th class="align-middle text-center">User Id</th>
                            <th class="align-middle text-center">Packeg Id</th>
                            <th class="align-middle text-center">Amount</th>
                            <th class="align-middle text-center">Months</th>
                            <th class="align-middle text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($adminbills as $adminbill)
                        <tr>
                            <td class="align-middle text-center">{{ ++$loop->index }}</td>
                            <td class="align-middle text-center">{{ $adminbill->name }}</td>
                            <td class="align-middle text-center">{{ $adminbill->user_id }}</td>
                            <td class="align-middle text-center">{{ $adminbill->package_id }}</td>
                            <td class="align-middle text-center">{{ $adminbill->amounts }}</td>
                            <td class="align-middle text-center">{{ $adminbill->months }}</td>
                            <td class="align-middle text-center">{{ $adminbill->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tr>
                        <td class="align-middle text-center" colspan="4">Total Amount</td>
                        <td class="align-middle text-center">{{ $adminbills->sum('amounts') }}</td>
                        <td class="align-middle text-center" colspan="2"></td>
                    </tr>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
