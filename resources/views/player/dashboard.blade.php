@extends('layout.master')

@section('APP-TITLE')
    Dashboard | Player
@endsection

@section('APP-CSS')
    <style>
        .radio {
            margin-right: 15px;
        }

        .profile-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }
    </style>
@endsection

@section('APP-CONTENT')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Player Dashboard</h1>
        </div>

        @if (!$player)
            <div class="alert alert-warning" role="alert">
                No player profile found. Please contact the administrator.
            </div>
        @else
            <!-- Player Profile -->
            <div class="row">
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4 profile-card">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">My Profile</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Name:</strong> {{ $player->user->first_name }} {{ $player->user->last_name }}
                            </div>
                            <div class="mb-3">
                                <strong>Belt Level:</strong> {{ $player->belt_level }}
                            </div>
                            <div class="mb-3">
                                <strong>Gender:</strong> {{ $player->gender }}
                            </div>
                            <div class="mb-3">
                                <strong>Chapter:</strong> {{ $player->chapter->chapter_name ?? 'Not Assigned' }}
                            </div>
                            <div class="mb-3">
                                <strong>Coach:</strong>
                                {{ $player->chapter && $player->chapter->coach ? $player->chapter->coach->first_name . ' ' . $player->chapter->coach->last_name : 'Not Assigned' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Cards -->
                <div class="col-xl-8 col-lg-7">
                    <div class="row">
                        <!-- Total Tournaments Card -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Tournaments Participated
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ \App\Models\KyorugiTournamentPlayer::where('player_id', $player->user_id)->count() }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-trophy fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Upcoming Tournaments Card -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Upcoming Tournaments
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ \App\Models\KyorugiTournamentPlayer::where('player_id', $player->user_id)->join('kyorugi_tournaments', 'kyorugi_tournament_player.tournament_id', '=', 'kyorugi_tournaments.id')->where('kyorugi_tournaments.start_date', '>=', now())->count() }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Tournaments Table -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Upcoming Tournaments</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tournamentsTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tournament Name</th>
                                            <th>Start Date</th>
                                            <th>Venue</th>
                                            <th>Division</th>
                                            <th>Weight Class</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (\App\Models\KyorugiTournamentPlayer::where('player_id', $player->user_id)->join('kyorugi_tournaments', 'kyorugi_tournament_player.tournament_id', '=', 'kyorugi_tournaments.id')->where('kyorugi_tournaments.start_date', '>=', now())->select('kyorugi_tournaments.*', 'kyorugi_tournament_player.division', 'kyorugi_tournament_player.weight_class', 'kyorugi_tournament_player.status')->get() as $tournament)
                                            <tr>
                                                <td>{{ $tournament->name }}</td>
                                                <td>{{ date('M d, Y', strtotime($tournament->start_date)) }}</td>
                                                <td>{{ $tournament->venue_name ?? 'TBD' }}</td>
                                                <td>{{ $tournament->division }}</td>
                                                <td>{{ $tournament->weight_class }}</td>
                                                <td>{{ $tournament->status }}</td>
                                                <td>
                                                    <a href="{{ route('tournaments.show', $tournament->id) }}"
                                                        class="btn btn-sm btn-primary">View</a>
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
        @endif
    </div>
@endsection

@section('APP-SCRIPT')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            var player = @json($player);

            if (!player) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Player Profile',
                    text: 'Your player profile is not set up. Please contact the administrator.',
                    confirmButtonText: 'Logout',
                    allowOutsideClick: false,
                    preConfirm: () => {
                        window.location.href = "{{ route('signout') }}";
                    }
                });
            }
        });
    </script>
@endsection
