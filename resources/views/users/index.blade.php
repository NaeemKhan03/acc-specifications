@extends('layouts.master')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Users List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>External User Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($users))
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->external_user_id ?? '' }}</td>
                                    <td>{{ $user->name ?? '' }}</td>
                                    <td>{{ $user->email ?? '' }}</td>
                                    <td><a href="{{ route('userDetails', $user->external_user_id) }}"
                                            class="btn btn-sm btn-primary">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex p-2">
                            {!! $users->appends(['per_page' => request()->per_page])->links() !!}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection