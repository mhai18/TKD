@extends('layout.master')

@section('APP-TITLE')
    Admin Dashboard
@endsection

@section('dashboard')
    active
@endsection

@section('APP-CONTENT')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Admin Dashboard</h1>
        </div>

        <!-- Dashboard Cards -->
        <div class="row">
            <!-- Total Users Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Users
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\User::count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Chapters Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Chapters
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\Chapter::count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-building fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Roles Breakdown -->
        <div class="row">
            <div class="col-xl-6 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">User Roles Breakdown</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="userRolesTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>User Role</th>
                                        <th>Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (\App\Models\User::select('user_type')->distinct()->get() as $type)
                                        <tr>
                                            <td>{{ $type->user_type }}</td>
                                            <td>{{ \App\Models\User::where('user_type', $type->user_type)->count() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chapters Overview -->
            <div class="col-xl-6 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Chapters Overview</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="chaptersTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Chapter Name</th>
                                        <th>Start Date</th>
                                        <th>Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (\App\Models\Chapter::orderBy('date_started', 'desc')->take(5)->get() as $chapter)
                                        <tr>
                                            <td>{{ $chapter->chapter_name }}</td>
                                            <td>{{ date('M d, Y', strtotime($chapter->date_started)) }}</td>
                                            <td>
                                                {{ \App\Models\Province::where('province_code', $chapter->province_code)->first()->province_name ?? 'N/A' }},
                                                {{ \App\Models\Municipality::where('municipality_code', $chapter->municipality_code)->first()->municipality_name ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
