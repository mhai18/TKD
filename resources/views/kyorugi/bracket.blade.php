@extends('layout.master')
@section('APP-CSS')
    <style>
        .winner-glow {
            box-shadow: 0 0 15px 5px rgba(40, 167, 69, 0.5);
            /* Green glow */
            border: 3px solid #28a745 !important;
            /* Force green border */
        }
    </style>
@endsection
@section('APP-CONTENT')
    <div class="container-fluid py-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-auto mb-4">
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="goBack()">
                    <i class="bi bi-arrow-left-circle me-1"></i> Go Back
                </button>
                <script>
                    function goBack() {
                        window.history.back();
                    }
                </script>
            </div>

            @if ($selectedRound && $canGenerateNextRound)
                <div class="col-auto mb-4">
                    <button id="generateNextRoundBtn" class="btn btn-success btn-sm">
                        <i class="bi bi-arrow-down-circle me-1"></i> Generate Next Round
                    </button>
                </div>
            @endif
            <div class="col-12">
                <h4 class="mb-4 text-primary fw-bold">
                    <i class="bi bi-trophy-fill me-2"></i> Bracket for: {{ $tournament->name }}
                </h4>

                <div class="accordion" id="divisionAccordion">
                    @foreach ($matches as $division => $weights)
                        <div class="accordion-item mb-3 border rounded shadow-sm">
                            <h2 class="accordion-header" id="heading-{{ Str::slug($division) }}">
                                <button class="accordion-button bg-gradient-primary text-white fw-bold collapsed"
                                    type="button" data-toggle="collapse" data-target="#collapse-{{ Str::slug($division) }}"
                                    aria-expanded="false" aria-controls="collapse-{{ Str::slug($division) }}">
                                    <i class="bi bi-diagram-3-fill me-2"></i> Division: {{ $division }}
                                </button>
                            </h2>
                            <div id="collapse-{{ Str::slug($division) }}" class="accordion-collapse collapse"
                                aria-labelledby="heading-{{ Str::slug($division) }}" data-parent="#divisionAccordion">
                                <div class="accordion-body bg-light">
                                    <div class="accordion" id="weightAccordion-{{ Str::slug($division) }}">
                                        @foreach ($weights as $weight => $rounds)
                                            <div class="accordion-item mb-2 border rounded shadow-sm">
                                                <h2 class="accordion-header"
                                                    id="weight-heading-{{ Str::slug($division . $weight) }}">
                                                    <button
                                                        class="accordion-button collapsed bg-gradient-info text-white fw-bold"
                                                        type="button" data-toggle="collapse"
                                                        data-target="#weight-collapse-{{ Str::slug($division . $weight) }}"
                                                        aria-expanded="false"
                                                        aria-controls="weight-collapse-{{ Str::slug($division . $weight) }}">
                                                        <i class="bi bi-bar-chart-steps me-2"></i> Weight:
                                                        {{ $weight }}
                                                    </button>
                                                </h2>
                                                <div id="weight-collapse-{{ Str::slug($division . $weight) }}"
                                                    class="accordion-collapse collapse"
                                                    aria-labelledby="weight-heading-{{ Str::slug($division . $weight) }}"
                                                    data-parent="#weightAccordion-{{ Str::slug($division) }}">
                                                    <div class="accordion-body bg-white">
                                                        @foreach ($rounds as $round => $matchesPerRound)
                                                            <div class="card">
                                                                <div class="card-content">
                                                                    <div class="card-header">
                                                                        <h5 class="card-title">
                                                                            <i class="bi bi-arrow-repeat me-1"></i> Round
                                                                            {{ $round }}
                                                                        </h5>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            @foreach ($matchesPerRound as $match)
                                                                                <div class="col-md-6 col-lg-6 mb-4">
                                                                                    <div
                                                                                        class="card border-0 shadow rounded-3 h-100">
                                                                                        <div class="card-body">
                                                                                            {{-- Players --}}
                                                                                            <div
                                                                                                class="row align-items-center text-center">
                                                                                                {{-- Red Player --}}
                                                                                                <div class="col-5">
                                                                                                    <h6
                                                                                                        class="text-muted mb-2">
                                                                                                        Red Corner</h6>
                                                                                                    <div
                                                                                                        class="{{ $match->winner_id === $match->player_red_id ? 'fw-bold text-success' : '' }}">
                                                                                                        {{ optional($match->redPlayer)->full_name ?? 'TBA' }}
                                                                                                        @if ($match->winner_id === $match->player_red_id)
                                                                                                            <span
                                                                                                                class="badge bg-success ms-1">Winner</span>
                                                                                                        @endif
                                                                                                    </div>
                                                                                                </div>

                                                                                                {{-- VS --}}
                                                                                                <div class="col-2">
                                                                                                    <span
                                                                                                        class="fw-bold text-secondary">VS</span>
                                                                                                </div>

                                                                                                {{-- Blue Player --}}
                                                                                                @if (!$match->is_bye)
                                                                                                    <div class="col-5">
                                                                                                        <h6
                                                                                                            class="text-muted mb-2">
                                                                                                            Blue Corner</h6>
                                                                                                        <div
                                                                                                            class="{{ $match->winner_id === $match->player_blue_id ? 'fw-bold text-success' : '' }}">
                                                                                                            {{ optional($match->bluePlayer)->full_name ?? 'TBA' }}
                                                                                                            @if ($match->winner_id === $match->player_blue_id)
                                                                                                                <span
                                                                                                                    class="badge bg-success ms-1">Winner</span>
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @else
                                                                                                    <div class="col-5">
                                                                                                        <h6
                                                                                                            class="text-muted mb-2">
                                                                                                            Blue Corner</h6>
                                                                                                        <div
                                                                                                            class="text-muted fst-italic">
                                                                                                            BYE</div>
                                                                                                    </div>
                                                                                                @endif
                                                                                            </div>

                                                                                            {{-- Divider --}}
                                                                                            <hr class="my-3">

                                                                                            {{-- Status and Actions --}}
                                                                                            <div
                                                                                                class="d-flex justify-content-between align-items-center">
                                                                                                <small class="text-muted">
                                                                                                    <i
                                                                                                        class="bi bi-info-circle me-1"></i>
                                                                                                    Status:
                                                                                                    {{ ucfirst($match->match_status->value) }}
                                                                                                </small>
                                                                                                <button
                                                                                                    class="btn btn-sm btn-outline-primary"
                                                                                                    data-toggle="modal"
                                                                                                    data-target="#matchModal-{{ $match->id }}">
                                                                                                    <i
                                                                                                        class="bi bi-eye-fill me-1"></i>
                                                                                                    View
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                {{-- Match Modal --}}
                                                                                <div class="modal fade"
                                                                                    id="matchModal-{{ $match->id }}"
                                                                                    tabindex="-1"
                                                                                    aria-labelledby="matchModalLabel-{{ $match->id }}"
                                                                                    aria-hidden="true">
                                                                                    <div
                                                                                        class="modal-dialog modal-dialog-centered modal-lg">
                                                                                        <div
                                                                                            class="modal-content border-0 shadow-lg">
                                                                                            <div
                                                                                                class="modal-header bg-primary text-white">
                                                                                                <h5 class="modal-title"
                                                                                                    id="matchModalLabel-{{ $match->id }}">
                                                                                                    Match Details - Round
                                                                                                    {{ $match->round }}
                                                                                                </h5>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                @php
                                                                                                    $isRedWinner =
                                                                                                        $match->winner_id ===
                                                                                                        $match->player_red_id;
                                                                                                    $isBlueWinner =
                                                                                                        $match->winner_id ===
                                                                                                        $match->player_blue_id;
                                                                                                @endphp
                                                                                                <div
                                                                                                    class="row text-center justify-content-center">
                                                                                                    {{-- Red Player Card --}}
                                                                                                    @php
                                                                                                        $redPlayer =
                                                                                                            $match->redPlayer;
                                                                                                        $redAvatar =
                                                                                                            $redPlayer?->user?->getFirstMediaUrl(
                                                                                                                'avatar',
                                                                                                                'thumbnail',
                                                                                                            ) ?:
                                                                                                            asset(
                                                                                                                'assets/images/user/1.jpg',
                                                                                                            );
                                                                                                        $redBelt =
                                                                                                            $redPlayer
                                                                                                                ?->player
                                                                                                                ->belt_level
                                                                                                                ->value ??
                                                                                                            'Unknown';
                                                                                                    @endphp

                                                                                                    <div
                                                                                                        class="col-md-{{ $match->is_bye ? '8' : '6' }} mb-3">
                                                                                                        <div
                                                                                                            class="card shadow-sm h-100 {{ $isRedWinner ? 'border-success winner-glow' : 'border-danger' }}">
                                                                                                            <div
                                                                                                                class="card-header bg-danger text-white fw-bold">
                                                                                                                <i
                                                                                                                    class="bi bi-circle-fill me-2"></i>
                                                                                                                Red Player
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="card-body d-flex flex-column align-items-center">
                                                                                                                <img src="{{ $redAvatar }}"
                                                                                                                    class="rounded-circle mb-3"
                                                                                                                    alt="Red Player Avatar"
                                                                                                                    style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #dc3545;">
                                                                                                                <h5
                                                                                                                    class="card-title mb-1">
                                                                                                                    {{ $redPlayer?->full_name ?? 'TBA' }}
                                                                                                                </h5>
                                                                                                                @if ($isRedWinner)
                                                                                                                    <span
                                                                                                                        class="badge bg-success mb-2">
                                                                                                                        <i
                                                                                                                            class="bi bi-trophy-fill me-1"></i>
                                                                                                                        Winner
                                                                                                                    </span>
                                                                                                                @endif

                                                                                                                <small
                                                                                                                    class="text-muted mb-3">Belt
                                                                                                                    Level:
                                                                                                                    {{ $redBelt }}</small>
                                                                                                                @if (!$match->winner_id)
                                                                                                                    <button
                                                                                                                        class="btn btn-outline-danger"
                                                                                                                        onclick="setWinner({{ $match->id }}, {{ $match->player_red_id ?? 'null' }})">
                                                                                                                        <i
                                                                                                                            class="bi bi-trophy me-1"></i>
                                                                                                                        Set
                                                                                                                        as
                                                                                                                        Winner
                                                                                                                    </button>
                                                                                                                @endif
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    {{-- Blue Player Card (only if not BYE) --}}
                                                                                                    @if (!$match->is_bye)
                                                                                                        @php
                                                                                                            $bluePlayer =
                                                                                                                $match->bluePlayer;
                                                                                                            $blueAvatar =
                                                                                                                $bluePlayer?->user?->getFirstMediaUrl(
                                                                                                                    'avatar',
                                                                                                                    'thumbnail',
                                                                                                                ) ?:
                                                                                                                asset(
                                                                                                                    'assets/images/user/1.jpg',
                                                                                                                );
                                                                                                            $blueBelt =
                                                                                                                $bluePlayer
                                                                                                                    ?->player
                                                                                                                    ->belt_level
                                                                                                                    ->value ??
                                                                                                                'Unknown';
                                                                                                        @endphp

                                                                                                        <div
                                                                                                            class="col-md-6 mb-3">
                                                                                                            <div
                                                                                                                class="card shadow-sm h-100 {{ $isBlueWinner ? 'border-success winner-glow' : 'border-primary' }}">
                                                                                                                <div
                                                                                                                    class="card-header bg-primary text-white fw-bold">
                                                                                                                    <i
                                                                                                                        class="bi bi-circle-fill me-2"></i>
                                                                                                                    Blue
                                                                                                                    Player
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="card-body d-flex flex-column align-items-center">
                                                                                                                    <img src="{{ $blueAvatar }}"
                                                                                                                        class="rounded-circle mb-3"
                                                                                                                        alt="Blue Player Avatar"
                                                                                                                        style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #0d6efd;">
                                                                                                                    <h5
                                                                                                                        class="card-title mb-1">
                                                                                                                        {{ $bluePlayer?->full_name ?? 'TBA' }}
                                                                                                                    </h5>
                                                                                                                    @if ($isBlueWinner)
                                                                                                                        <span
                                                                                                                            class="badge bg-success mb-2">
                                                                                                                            <i
                                                                                                                                class="bi bi-trophy-fill me-1"></i>
                                                                                                                            Winner
                                                                                                                        </span>
                                                                                                                    @endif

                                                                                                                    <small
                                                                                                                        class="text-muted mb-3">Belt
                                                                                                                        Level:
                                                                                                                        {{ $blueBelt }}</small>
                                                                                                                    @if (!$match->winner_id)
                                                                                                                        <button
                                                                                                                            class="btn btn-outline-primary"
                                                                                                                            onclick="setWinner({{ $match->id }}, {{ $match->player_blue_id ?? 'null' }})">
                                                                                                                            <i
                                                                                                                                class="bi bi-trophy me-1"></i>
                                                                                                                            Set
                                                                                                                            as
                                                                                                                            Winner
                                                                                                                        </button>
                                                                                                                    @endif
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    @endif
                                                                                                </div>

                                                                                                <hr class="my-4">

                                                                                                <div class="text-center">
                                                                                                    <p class="mb-1">
                                                                                                        <strong>Status:</strong>
                                                                                                        {{ ucfirst($match->match_status->value) }}
                                                                                                    </p>
                                                                                                    <p class="mb-0">
                                                                                                        <strong>Winner:</strong>
                                                                                                        <span
                                                                                                            class="text-success fw-bold">
                                                                                                            {{ optional($match->winner)->full_name ?? 'TBA' }}
                                                                                                        </span>
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div
                                                                                                class="modal-footer justify-content-center">
                                                                                                <button type="button"
                                                                                                    class="btn btn-secondary"
                                                                                                    data-dismiss="modal">
                                                                                                    <i
                                                                                                        class="bi bi-x-circle me-1"></i>
                                                                                                    Close
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection
@section('APP-SCRIPT')
    <script type="text/javascript">
        function setWinner(matchesID, winnerID) {
            $('#matchModal-' + matchesID).modal('hide');
            $.ajax({
                method: 'PUT',
                url: `/kyorugiTournamentMatches/${matchesID}`,
                data: {
                    winner_id: winnerID
                },
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    console.log('✅ Success:', response.message);
                    console.log('👤 Player:', response.data);
                    showDatumAlert('success', response.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let errorList = '';
                        for (let field in errors) {
                            errorList += `${field}: ${errors[field].join(', ')}\n`;
                        }
                        showDatumAlert('danger', 'Validation Error:\n' + errorList);
                    } else {
                        showDatumAlert('danger', xhr.responseJSON?.message ||
                            'Unexpected server error.');
                        console.error('Full error:', xhr.responseJSON);
                    }
                }
            });
        }

        $(document).ready(function() {

            $('#generateNextRoundBtn').on('click', function(e) {
                e.preventDefault();

                let $btn = $(this);
                $btn.prop('disabled', true).html(
                    '<i class="bi bi-arrow-repeat me-1 spinner-border spinner-border-sm"></i> Generating...'
                );

                $.ajax({
                    url: "{{ route('generateNextRound', ['tournamentID' => $tournament->id]) }}",
                    type: 'POST',
                    success: function(response) {
                        if (response.data.length === 0) {
                            showDatumAlert('info', response.message); // Matches are concluded
                        } else {
                            showDatumAlert('success', response
                                .message); // Round successfully generated

                            setTimeout(() => {
                                location.reload();
                            }, 1000);

                        }

                        $btn.prop('disabled', false).html(
                            '<i class="bi bi-arrow-down-circle me-1"></i> Generate Next Round'
                        );
                    },
                    error: function(response) {
                        showDatumAlert('danger', response.responseJSON?.message ||
                            'Unexpected server error.');
                        console.error('Full error:', response.responseJSON);
                        $btn.prop('disabled', false).html(
                            '<i class="bi bi-arrow-down-circle me-1"></i> Generate Next Round'
                        );
                    }
                });
            });

        });
    </script>
@endsection
