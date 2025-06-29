@extends('layout.master')

@section('APP-TITLE')
    Chairman Dashboard
@endsection

@section('dashboard')
    active
@endsection

@section('APP-CONTENT')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Chairman Dashboard</h1>
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

            <!-- Total Tournaments Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Active Tournaments
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\KyorugiTournament::where('status', '!=', 'DRAFT')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-trophy fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Players Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Players
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\Player::count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-friends fa-2x text-gray-300"></i>
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

        <!-- Main Content Area -->
        <div class="row">
            <!-- Recent Tournaments Table -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Tournaments</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tournamentsTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Start Date</th>
                                        <th>Venue</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (\App\Models\KyorugiTournament::orderBy('start_date', 'desc')->take(5)->get() as $tournament)
                                        <tr>
                                            <td>{{ $tournament->name }}</td>
                                            <td>{{ date('M d, Y', strtotime($tournament->start_date)) }}</td>
                                            <td>{{ $tournament->venue_name ?? 'TBD' }}</td>
                                            <td>{{ $tournament->status }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Stats</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="font-weight-bold">User Types</h6>
                            <ul class="list-group">
                                @foreach (\App\Models\User::select('user_type')->distinct()->get() as $type)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $type->user_type }}
                                        <span class="badge badge-primary badge-pill">
                                            {{ \App\Models\User::where('user_type', $type->user_type)->count() }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mb-3">
                            <h6 class="font-weight-bold">Gender Distribution</h6>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Male
                                    <span class="badge badge-primary badge-pill">
                                        {{ \App\Models\Player::where('gender', 'Male')->count() }}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Female
                                    <span class="badge badge-primary badge-pill">
                                        {{ \App\Models\Player::where('gender', 'Female')->count() }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
