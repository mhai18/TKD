@extends('layout.master')

@section('APP-TITLE')
    Dashboard | Coach
@endsection

@section('dashboard')
    active
@endsection

@section('APP-CSS')
    <style>
        .radio {
            margin-right: 15px;
        }

        .chapter-select {
            min-width: 200px;
        }
    </style>
@endsection

@section('APP-CONTENT')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Coach Dashboard</h1>
            @if ($chapters->isNotEmpty())
                <div class="form-group mb-0">
                    <select id="chapterSelect" class="form-control chapter-select"
                        onchange="window.location.href='{{ route('coachDashboard') }}?chapter_id='+this.value">
                        <option value="">Select a Chapter</option>
                        @foreach ($chapters as $chapter)
                            <option value="{{ $chapter->id }}"
                                {{ $selectedChapter && $selectedChapter->id == $chapter->id ? 'selected' : '' }}>
                                {{ $chapter->chapter_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        @if ($chapters->isEmpty())
            <div class="alert alert-warning" role="alert">
                No chapters assigned. Please contact the administrator.
            </div>
        @elseif(!$selectedChapter)
            <div class="alert alert-info" role="alert">
                Please select a chapter to view its details.
            </div>
        @else
            <!-- Dashboard Cards -->
            <div class="row">
                <!-- Total Players Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Players
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ \App\Models\Player::where('chapter_id', $selectedChapter->id)->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Tournaments Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Upcoming Tournaments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ \App\Models\KyorugiTournamentPlayer::whereIn(
                                            'player_id',
                                            \App\Models\Player::where('chapter_id', $selectedChapter->id)->pluck('user_id'),
                                        )->join('kyorugi_tournaments', 'kyorugi_tournament_player.tournament_id', '=', 'kyorugi_tournaments.id')->where('kyorugi_tournaments.start_date', '>=', now())->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-trophy fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="row">
                <!-- Players List -->
                <div class="col-xl-6 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Players in {{ $selectedChapter->chapter_name }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="playersTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Belt Level</th>
                                            <th>Gender</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (\App\Models\Player::where('chapter_id', $selectedChapter->id)->with('user')->get() as $player)
                                            <tr>
                                                <td>{{ $player->user->first_name }} {{ $player->user->last_name }}</td>
                                                <td>{{ $player->belt_level }}</td>
                                                <td>{{ $player->gender }}</td>
                                                <td>
                                                    <a href="{{ route('players.show', $player->user_id) }}"
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

                <!-- Upcoming Tournaments -->
                <div class="col-xl-6 col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Upcoming Tournaments</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tournamentsTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Start Date</th>
                                            <th>Venue</th>
                                            <th>Players</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (\App\Models\KyorugiTournamentPlayer::whereIn('player_id', \App\Models\Player::where('chapter_id', $selectedChapter->id)->pluck('user_id'))->join('kyorugi_tournaments', 'kyorugi_tournament_player.tournament_id', '=', 'kyorugi_tournaments.id')->where('kyorugi_tournaments.start_date', '>=', now())->select('kyorugi_tournaments.*')->distinct()->get() as $tournament)
                                            <tr>
                                                <td>{{ $tournament->name }}</td>
                                                <td>{{ date('M d, Y', strtotime($tournament->start_date)) }}</td>
                                                <td>{{ $tournament->venue_name ?? 'TBD' }}</td>
                                                <td>
                                                    {{ \App\Models\KyorugiTournamentPlayer::where('tournament_id', $tournament->id)->whereIn('player_id', \App\Models\Player::where('chapter_id', $selectedChapter->id)->pluck('user_id'))->count() }}
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
            var chapters = @json($chapters);

            if (chapters.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Chapters Assigned',
                    text: 'You need to be assigned to a chapter to proceed.',
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
