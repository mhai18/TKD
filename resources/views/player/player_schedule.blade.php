@extends('layout.master')
@section('schedule')
    active
@endsection
@section('APP-TITLE')
    Player Schedule
@endsection
@section('APP-CONTENT')
    <div class="row">
        <div class="col-md-12">
            <div class="iq-card">
                <div class="iq-card-body">
                    <h4 class="card-title">Matches</h4>
                    <div class="row">
                        @foreach ($matches as $match)
                            @foreach ($match->matches as $tournamentMatch)
                                <div class="col-sm-6 col-md-4 col-lg-4 mb-4">
                                    <div class="card shadow-sm border-0">
                                        <div class="position-relative">
                                            <img src="https://img.freepik.com/premium-photo/modern-olympic-taekwondo-banner-showcasing-athlete-aggression-with-abstract-colorful-background-design_416256-63210.jpg"
                                                class="card-img-top rounded-top" alt="Player Avatar">
                                            <div class="badge badge-primary position-absolute"
                                                style="top: 10px; right: 10px;">
                                            </div>
                                        </div>
                                        <div class="card-body text-center">
                                            <h5 class="card-title font-weight-bold mb-2">Tournament Name:
                                                {{ $match->tournament->name }}</h5>
                                            <p class="text-dark">Schedule: <span
                                                    class="text-primary">{{ date('F j, Y', strtotime($tournamentMatch->match_datetime ?? $match->tournament->start_date)) }}</span>
                                            </p>
                                            @if ($tournamentMatch->match_status->value === \App\Enums\MatchStatus::SCHEDULED->value)
                                                <p class="badge badge-warning">Status: Scheduled</p>
                                            @elseif ($tournamentMatch->match_status->value === \App\Enums\MatchStatus::COMPLETED->value)
                                                <p class="badge badge-success">Status: Completed</p>
                                            @elseif ($tournamentMatch->match_status->value === \App\Enums\MatchStatus::ONGOING->value)
                                                <p class="badge badge-info">Status: Ongoing</p>
                                            @elseif ($tournamentMatch->match_status->value === \App\Enums\MatchStatus::CANCELLED->value)
                                                <p class="badge badge-danger">Status: Cancelled</p>
                                            @elseif ($tournamentMatch->match_status->value === \App\Enums\MatchStatus::FORFEIT->value)
                                                <p class="badge badge-secondary">Status: Forfeit</p>
                                            @else
                                                <p class="badge badge-secondary">Status: Unknown</p>
                                            @endif
                                            <br>
                                            <button type="button"
                                                onclick="viewMatches({{ $match->player->id }}, {{ $match->tournament->id }})"
                                                class="btn btn-outline-primary btn-sm">View Matches</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Player Performant Modal --}}
    <div class="modal fade" id="playerPerformanceModal" tabindex="-1" aria-labelledby="playerPerformanceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body" id="performanceContent">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('APP-SCRIPT')
    <script>
        function viewMatches(playerId, tournamentId) {
            $('#performanceContent').html('<p>Loading performance data...</p>');
            $.ajax({
                url: `/players/${playerId}/${tournamentId}/matches`,
                type: "GET",
                dataType: "html",
                cache: false,
                success: function(response) {
                    $('#performanceContent').html(response);
                    $('#playerPerformanceModal').modal('show');
                },
                error: function(xhr, status, error) {
                    $('#performanceContent').html(
                        '<p class="text-danger">Failed to load player performance.</p>');
                    console.error("Error fetching matches:", error);
                }
            });
        }

        // Player Modal Content Load
        const playerCards = document.querySelectorAll('.player-card');
        playerCards.forEach(card => {
            card.addEventListener('click', function() {
                document.getElementById('modalName').innerText = this.dataset.name;
                document.getElementById('modalChapter').innerText = this.dataset.chapter;
                document.getElementById('modalCoach').innerText = this.dataset.coach;
                document.getElementById('modalBelt').innerText = this.dataset.belt;
                document.getElementById('modalWeight').innerText = this.dataset.weight;
                document.getElementById('modalGender').innerText = this.dataset.gender;
                document.getElementById('modalCivil').innerText = this.dataset.civil;
                document.getElementById('modalAvatar').src = this.dataset.avatar;
            });
        });
    </script>
@endsection
