@extends('layouts.master')
@section('content')
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{ $userDetail->name ?? '' }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Vehicle</th>
                                        <th>Price</th>
                                        <th>Reg No</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($userDetail))
                                        @foreach ($userDetail->vehicles as $key => $value)
                                            <tr>
                                                <td><a
                                                        href="{{ route('show', $value['vehicle_id']) }}">{{ Str::limit($value['title'], 60, '...') ?? '' }}</a>
                                                </td>
                                                <td>{{ $value['price'] ?? '' }}</td>
                                                <td>{{ $value['reg_no'] ?? '' }}</td>
                                                <td>{{ $value['status'] ?? '' }}</td>

                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Payments</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Amount</th>
                                        <th>Type</th>
                                        <th>File</th>
                                        <th>Percentage(%)</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($userPayments))
                                        @foreach ($userPayments as $user)
                                            <tr>
                                                <td>{{ $user->amount ?? '' }}</td>
                                                <td>{{ $user->type ?? '' }}</td>
                                                <td>
                                                    <a href="{{ 'https://media.autocoincars.com/media/document/customer/' . $user->user_id . '/payment/' . $user->file }}"
                                                        target="_blank">{{ $user->file ?? 'File' }}</a>
                                                </td>
                                                <td>{{ $user->percentage ?? '' }}</td>
                                                <td>{{ $user->total ?? '' }}</td>
                                                <td>{{ $user->status ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
