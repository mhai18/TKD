@extends('layout.master')
@section('chapter')
    active
@endsection
@section('APP-TITLE')
    {{ $chapter->chapter_name }} | Coach
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
                        <img src="{{ $chapter->coach->getFirstMediaUrl('avatar', 'thumb') ?: asset('assets/images/user/1.jpg') }}"
                            alt="profile-bg" class="avatar-100 rounded d-block mx-auto img-fluid mb-3">
                        <h3 class="font-600 text-white text-center mb-0">{{ $chapter->coach->full_name }}</h3>
                        <p class="text-white text-center mb-5">Coach</p>
                    </div>
                    <div class="pro-content rounded">
                        <div class="d-flex align-items-center mb-3">
                            <div class="p-icon mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-primary" width="20" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                                </svg>
                            </div>
                            <p class="mb-0 eml">{{ $chapter->coach->email }}</p>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="p-icon mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-primary" width="20" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 8l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z" />
                                </svg>
                            </div>
                            <p class="mb-0">{{ $chapter->coach->contact_number }}</p>
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
                            <p class="mb-0">BRGY. {{ $chapter->coach->committee->full_address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card card-block">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Chapter: <span class="text-primary">{{ $chapter->chapter_name }}</span></h4>
                    <h4 class="card-title mb-0">Started: <span
                            class="text-primary">{{ date('F j, Y', strtotime($chapter->date_started)) }}</span></h4>
                </div>
                <div class="card-header">
                    <h4 class="card-title mb-0">Location: BRGY. {{ $chapter->full_address }}</h4>
                </div>
                <div class="card-header">
                    <h4 class="card-title mb-0">List of Players</h4>
                </div>
                <div class="card-body scrollable-content">
                    <div class="row">
                        @if ($chapter->players->isEmpty())
                            <div class="col-12 text-center alert alert-info shadow-sm rounded">
                                <div class="py-5">
                                    <h4 class="mb-3 font-weight-bold text-primary">No Players Found</h4>
                                    <p class="mb-4 text-muted">It seems there are no players registered in this chapter yet. Please check back later or add new players to this chapter.</p>
                                </div>
                            </div>
                        @else
                            @foreach ($chapter->players as $player)
                                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card shadow-sm border-0">
                                        <div class="position-relative">
                                            <img src="{{ $player->user->getFirstMediaUrl('avatar', 'thumb') ?: asset('assets/images/user/1.jpg') }}"
                                                class="card-img-top rounded-top" alt="Player Avatar">
                                            <div class="badge badge-primary position-absolute"
                                                style="top: 10px; right: 10px;">
                                                {{ ucfirst(str_replace('_', ' ', $player->belt_level->value)) }}
                                            </div>
                                        </div>
                                        <div class="card-body text-center">
                                            <h5 class="card-title font-weight-bold mb-2">{{ $player->user->full_name }}</h5>
                                            <a href="{{ url('/tm/viewPlayer/' . $player->id) }}"
                                                class="btn btn-outline-primary btn-sm">View Profile</a>
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
@endsection
