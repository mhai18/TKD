@extends('layout.master')
@section('kyorugi')
    active
@endsection
@section('APP-TITLE')
    {{ $tournament->name }} | Coach
@endsection
@section('APP-CSS')
    <style>
        .profile-card {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: #fff;
        }

        .profile-card img {
            border: 3px solid #fff;
        }

        .pro-content {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
        }

        .card-title span {
            font-weight: bold;
        }

        .scrollable-content {
            max-height: 70vh;
            overflow-y: auto;
            scroll-behavior: smooth;
        }

        .card img {
            transition: transform 0.3s ease;
        }

        .card img:hover {
            transform: scale(1.05);
        }

        .card-body {
            background: #f8f9fa;
            border-top: 1px solid #ddd;
        }

        .card-body h4 {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .card-body p {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
@endsection
@section('APP-CONTENT')
    <div class="row">
        <div class="col-lg-12 mb-4">
            <button type="button" class="btn btn-md btn-primary" onclick="goBack()">Go Back</button>
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>
        </div>
        <div class="col-lg-4">
            <div class="card card-block p-card">
                <div class="profile-box">
                    <div class="profile-card rounded">
                        <img src="{{ $tournament->getFirstMediaUrl('avatar', 'thumb') ?: asset('assets/images/user/1.jpg') }}"
                            alt="profile-bg" class="avatar-100 rounded d-block mx-auto img-fluid mb-3">
                        <h3 class="font-600 text-white text-center mb-0">{{ $tournament->name }}</h3>
                        <p class="text-white text-center mb-5">Name</p>
                    </div>
                    <div class="pro-content rounded">
                        <div class="d-flex align-items-center mb-3">
                            <div class="p-icon mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-primary" width="20" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p class="mb-0">{{ $tournament->venue_name }}</p>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="p-icon mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-primary" width="20" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p class="mb-0">{{ $tournament->full_address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card card-block">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Start Date: <span
                            class="text-primary">{{ date('F j, Y', strtotime($tournament->start_date)) }}</span></h4>
                    <h4 class="card-title mb-0">End Date: <span
                            class="text-primary">{{ date('F j, Y', strtotime($tournament->end_date)) }}</span></h4>
                </div>
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Registration Start: <span
                            class="text-primary">{{ date('F j, Y', strtotime($tournament->registration_start)) }}</span>
                    </h4>
                    <h4 class="card-title mb-0">Registration End: <span
                            class="text-primary">{{ date('F j, Y', strtotime($tournament->registration_end)) }}</span></h4>
                </div>
                <div class="card-body scrollable-content">
                    <div class="row">
                        @if ($tournament->status === \App\Enums\TournamentStatus::DRAFT)
                            <div class="col-12 text-right mb-2">
                                <button class="btn btn-md btn-primary" data-toggle="modal" data-target="#addPlayer">Register
                                    Player</button>
                            </div>
                        @endif
                        @if ($registeredPlayers->isEmpty())
                            <div class="col-12 text-center alert alert-info shadow-sm rounded">
                                <div class="py-5">
                                    <h4 class="mb-3 font-weight-bold text-primary">No Players Found</h4>
                                    <p class="mb-4 text-muted">It seems there are no players registered in this tournament
                                        yet.
                                        Please check back later or register new players to this tournament.</p>
                                </div>
                            </div>
                        @else
                            @foreach ($registeredPlayers as $registered)
                                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card shadow-sm border-0">
                                        <div class="position-relative">
                                            <img src="{{ $registered->player->getFirstMediaUrl('avatar', 'thumb') ?: asset('assets/images/user/1.jpg') }}"
                                                class="card-img-top rounded-top" alt="Player Avatar">
                                            <div class="badge badge-primary position-absolute"
                                                style="top: 10px; right: 10px;">
                                                {{ ucfirst(str_replace('_', ' ', $registered->player->player->belt_level->value)) }}
                                            </div>
                                        </div>
                                        <div class="card-body text-center">
                                            <h5 class="card-title font-weight-bold">
                                                {{ $registered->player->full_name }}
                                            </h5>
                                            <p class="card-title font-weight-bold">
                                                {{ $registered->weight_class->value }} Weight
                                            </p>
                                            <a href="{{ url('/coach/viewPlayer/' . $registered->player->id) }}"
                                                class="btn btn-outline-primary btn-sm mb-2">View Profile</a>
                                            @if ($tournament->status === \App\Enums\TournamentStatus::DRAFT)
                                                <button class="btn btn-outline-danger btn-sm"
                                                    onclick="removePlayer({{ $registered->id }})">Remove Player</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addPlayer" tabindex="-1" role="dialog" aria-labelledby="addPlayerLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="addForm" class="modal-content needs-validation" novalidate>
                <input type="hidden" class="form-control" id="tournament_id" name="tournament_id"
                    value="{{ $tournament->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPlayerLabel">Add Player</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="player_id">Player:</label>
                        <select class="form-control choicesjs" name="player_id" id="player_id">
                            @foreach ($unregisteredPlayers as $player)
                                <option value="{{ $player->user->id }}">{{ ucwords($player->user->full_name) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please select a player.</div>
                    </div>

                    <div class="form-group">
                        <label for="division">Division:</label>
                        <select class="form-control choicesjs" name="division" id="division">
                            @foreach (\App\Enums\Division::cases() as $division)
                                <option value="{{ $division->value }}">{{ $division->value }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please select a division.</div>
                    </div>
                    <div class="form-group">
                        <label for="weight">Weight:</label>
                        <input type="number" class="form-control" name="weight" id="weight"
                            placeholder="Enter weight">
                        <div class="invalid-feedback">Weight is required.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('APP-SCRIPT')
    <script type="text/javascript">
        function removePlayer(playerId) {
            $.ajax({
                method: 'DELETE',
                url: `/kyorugiTournamentPlayers/${playerId}`,
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    console.log('✅ Player removed:', response.message);
                    showDatumAlert('success', response.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    showDatumAlert('danger', xhr.responseJSON?.message || 'Unexpected server error.');
                    console.error('Full error:', xhr.responseJSON);
                }
            });
        }

        $(document).ready(function() {

            $('#addForm').on('reset', function() {
                $(this).removeClass('was-validated');
                $(this).find('.is-invalid').removeClass('is-invalid');
                $(this).find('.invalid-feedback').hide();
            });

            $('#addForm').submit(function(event) {
                event.preventDefault();

                const form = this;

                // Add Bootstrap's validation class
                $(form).addClass('was-validated');

                // Prevent submission if form is invalid
                if (!form.checkValidity()) {
                    return false;
                }

                const formData = new FormData(form);

                $.ajax({
                    method: 'POST',
                    url: '/kyorugiTournamentPlayers',
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        $('#addPlayer').modal('hide');
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

                                // Optionally show error beside the field
                                const $input = $(`[name="${field}"]`);

                                if ($input.length) {
                                    $input.addClass('is-invalid');
                                    $input.prop('required', true);

                                    if ($input.is('select')) {
                                        $input.closest('.form-group').find('.invalid-feedback')
                                            .text(errors[field][0]).show();
                                    } else {
                                        $input.next('.invalid-feedback').text(errors[field][0])
                                            .show();
                                    }
                                }
                            }
                            showDatumAlert('danger', 'Validation Error:\n' + errorList);
                        } else {
                            showDatumAlert('danger', xhr.responseJSON?.message ||
                                'Unexpected server error.');
                            console.error('Full error:', xhr.responseJSON);
                        }
                    }
                });
            });
        });
    </script>
@endsection
