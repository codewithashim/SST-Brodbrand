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
                        <th class="align-middle text-center">User Id</th>
                        <th class="align-middle text-center">Packeg Id</th>
                        <th class="align-middle text-center">Amount</th>
                        <th class="align-middle text-center">Months</th>
                        <th class="align-middle text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companybills as $companybill)
                    <tr>
                        <td class="align-middle text-center">{{ ++$loop->index }}</td>
                        <td class="align-middle text-center">{{ $companybill->name }}</td>
                        <td class="align-middle text-center">{{ $companybill->user_id }}</td>
                        <td class="align-middle text-center">{{ $companybill->package_id }}</td>
                        <td class="align-middle text-center">{{ $companybill->amounts }}</td>
                        <td class="align-middle text-center">{{ $companybill->months }}</td>
                        <td class="align-middle text-center">{{ $companybill->status }}</td>
                    </tr>
                    @endforeach

                </tbody>
                <tr>
                    <td class="align-middle text-center" colspan="4">Total Amount</td>
                    <td class="align-middle text-center">{{ $companybills->sum('amounts') }}</td>
                    <td class="align-middle text-center" colspan="2"></td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection