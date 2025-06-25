@extends('layout.master')

@section('APP-TITLE', 'Tournament Summary')

@section('APP-CSS')
    <style>
        .card-img-top {
            object-fit: cover;
            height: 200px;
        }

        .medal-icon {
            font-size: 1.5rem;
            vertical-align: middle;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #3b3f5c;
            margin-top: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid #0d6efd;
            padding-left: 1rem;
        }

        .player-card {
            transition: all 0.3s ease-in-out;
        }

        .player-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.2rem rgba(0, 0, 0, 0.1);
        }

        .badge-custom {
            font-size: 0.85rem;
            padding: 0.4rem 0.75rem;
        }

        .tournament-header {
            background: #f1f2f7;
            padding: 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
        }
    </style>
@endsection

@section('APP-CONTENT')
    <div class="container-fluid">

        {{-- Filter Controls --}}
        <div class="row justify-content-between align-items-center">
            <div class="col-md-12 text-center">
                <h2 class="display-4 text-primary">{{ $tournament->name }} - Tournament Summary</h2>
                <p class="lead">Date: {{ date('F j, Y', strtotime($tournament->start_date)) }} to
                    {{ date('F j, Y', strtotime($tournament->end_date)) }}</p>
            </div>
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
            <div class="col-auto mb-4">
                <select class="form-select" id="divisionFilter">
                    <option value="">All Divisions</option>
                    @foreach ($winners as $division => $belts)
                        <option value="{{ Str::slug($division) }}">{{ $division }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Accordion --}}
        <div class="accordion" id="tournamentAccordion">
            @foreach ($winners as $division => $belts)
                @php $divisionSlug = Str::slug($division); @endphp
                <div class="accordion-item division-block" data-division="{{ $divisionSlug }}">
                    <h2 class="accordion-header" id="heading-{{ $loop->index }}">
                        <button
                            class="accordion-button bg-gradient-primary text-white fw-bold {{ $loop->first ? '' : 'collapsed' }}"
                            type="button" data-toggle="collapse" data-target="#collapse-{{ $loop->index }}"
                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                            aria-controls="collapse-{{ $loop->index }}">
                            <i class="bi bi-diagram-3-fill me-2"></i> Division: {{ $division }}
                        </button>
                    </h2>
                    <div id="collapse-{{ $loop->index }}"
                        class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                        aria-labelledby="heading-{{ $loop->index }}" data-parent="#tournamentAccordion">
                        <div class="accordion-body">

                            @foreach ($belts as $beltLevel => $weightClasses)
                                <div class="section-title">{{ $beltLevel }} Belt</div>
                                <div class="row mb-3">
                                    @foreach ($weightClasses as $weightClass => $genders)
                                        @foreach ($genders as $gender => $player)
                                            @if ($player)
                                                <div class="col-lg-4 col-md-6 mb-3">
                                                    <div class="card player-card h-100" data-toggle="modal"
                                                        data-name="{{ $player->user->full_name }}"
                                                        data-chapter="{{ $player->chapter->chapter_name ?? 'N/A' }}"
                                                        data-coach="{{ $player->coach->full_name ?? 'N/A' }}"
                                                        data-belt="{{ $player->belt_level->value ?? 'N/A' }}"
                                                        data-weight="{{ $weightClass }}"
                                                        data-gender="{{ $player->gender }}"
                                                        data-civil="{{ $player->civil_status->value ?? 'N/A' }}"
                                                        data-avatar="{{ $player->user->getFirstMediaUrl('avatar', 'thumbnail') ?: asset('assets/images/user/1.jpg') }}">
                                                        <img class="card-img-top"
                                                            src="{{ $player->user->getFirstMediaUrl('avatar', 'thumbnail') ?: asset('assets/images/user/1.jpg') }}"
                                                            alt="Player Avatar">
                                                        <div data-target="#playerModal" data-toggle="modal"
                                                            class="card-body">
                                                            <h5 class="card-title text-primary">
                                                                {{ $player->user->full_name }}
                                                            </h5>
                                                            <p class="card-text">
                                                                <strong>Weight Class:</strong> {{ $weightClass }}<br>
                                                                <strong>Gender:</strong> {{ ucfirst($gender) }}
                                                            </p>
                                                        </div>
                                                        <div class="card-footer d-flex justify-content-between">
                                                            <div class="text-left">
                                                                <span
                                                                    class="badge bg-secondary badge-custom">{{ $player->gender }}</span>
                                                                <span
                                                                    class="badge bg-secondary badge-custom">{{ $player->civil_status->value ?? 'N/A' }}</span>
                                                            </div>
                                                            <div class="text-right">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                    onclick="viewMatches('{{ $player->user->id }}')">
                                                                    <i class="bi bi-eye"></i> Matches
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{-- Player Details Modal --}}
    <div class="modal fade" id="playerModal" tabindex="-1" aria-labelledby="playerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Player Details</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-start">
                    <img id="modalAvatar" class="me-4 rounded" style="height: 150px; width: 150px; object-fit: cover;">
                    <div>
                        <h4 id="modalName" class="text-primary"></h4>
                        <p>
                            <strong>Chapter:</strong> <span id="modalChapter"></span><br>
                            <strong>Coach:</strong> <span id="modalCoach"></span><br>
                            <strong>Belt:</strong> <span id="modalBelt"></span><br>
                            <strong>Weight Class:</strong> <span id="modalWeight"></span><br>
                            <strong>Gender:</strong> <span id="modalGender"></span><br>
                            <strong>Civil Status:</strong> <span id="modalCivil"></span>
                        </p>
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
        function viewMatches(playerId) {
            $('#performanceContent').html('<p>Loading performance data...</p>');
            $.ajax({
                url: `/players/${playerId}/performance/export-pdf`,
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

        // Filter Division
        document.getElementById('divisionFilter').addEventListener('change', function() {
            let value = this.value;
            document.querySelectorAll('.division-block').forEach(function(block) {
                block.style.display = !value || block.dataset.division === value ? 'block' : 'none';
            });
        });

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
