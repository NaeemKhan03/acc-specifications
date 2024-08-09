@extends('layouts.master')
@section('content')
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Specification</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Spec Category</th>
                                        <th>Vehicle</th>
                                        <th>scrapped_spec</th>
                                        <th>specs_value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($specs))
                                        @foreach ($specs as $spec)
                                            <tr>
                                                <td>{{ $spec->category()->first()->name ?? '' }}</td>
                                                <td>{{ $spec->vehicle_id ?? '' }}</td>
                                                <td>{{ $spec->scrappedSpecs()->first()->label ?? '' }}</td>
                                                <td>{{ $spec->value ?? '' }}</td>
                                            </tr>
                                        @endforeach

                                </tbody>
                            </table>
                            <div class="d-flex p-2">
                                {!! $specs->appends(['per_page' => request()->per_page])->links() !!}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
