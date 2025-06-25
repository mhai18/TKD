@extends('layout.master')
@section('player')
    active
@endsection
@section('APP-CONTENT')
    <div class="col-lg-12 mb-4">
        <button type="button" class="btn btn-md btn-primary" onclick="goBack()">Go Back</button>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Player Profile</h4>
        </div>
        <div class="card-body">
            <!-- Profile Image -->
            <div class="text-center mb-4">
                <img id="profileImage" class="rounded-circle avatar-100"
                    src="{{ $player->user->getFirstMediaUrl('avatar') ?: asset('assets/images/user/1.jpg') }}"
                    alt="profile-pic">
            </div>

            <!-- Player Information -->
            <h5 class="mb-3">Player Information</h5>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Member ID</th>
                        <td>{{ $player->member_id ?: 'N/A' }}</td>
                        <th>PTA ID</th>
                        <td>{{ $player->pta_id ?: 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>NCC ID</th>
                        <td>{{ $player->ncc_id ?: 'N/A' }}</td>
                        <th>Belt Level</th>
                        <td>{{ ucwords(str_replace('_', ' ', $player->belt_level->value)) ?: 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>User Type</th>
                        <td>{{ ucwords($player->user->user_type->value) ?: 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Personal Information -->
            <h5 class="mb-3">Personal Information</h5>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>First Name</th>
                        <td>{{ $player->user->first_name ?: 'N/A' }}</td>
                        <th>Middle Name</th>
                        <td>{{ $player->user->middle_name ?: 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td>{{ $player->user->last_name ?: 'N/A' }}</td>
                        <th>Extension Name</th>
                        <td>{{ $player->user->extension_name ?: 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Contact Number</th>
                        <td>{{ $player->user->contact_number ?: 'N/A' }}</td>
                        <th>Email Address</th>
                        <td>{{ $player->user->email ?: 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Birth Date</th>
                        <td>{{ $player->birth_date ?: 'N/A' }}</td>
                        <th>Gender</th>
                        <td>{{ $player->gender ?: 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Civil Status</th>
                        <td>{{ $player->civil_status ?: 'N/A' }}</td>
                        <th>Religion</th>
                        <td>{{ $player->religion ?: 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Address Information -->
            <h5 class="mb-3">Address Information</h5>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Province</th>
                        <td>{{ $player->province?->province_name ?? 'N/A' }}</td>
                        <th>Municipality</th>
                        <td>{{ $player->municipality?->municipality_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Barangay</th>
                        <td>{{ $player->brgy?->brgy_name ?? 'N/A' }}</td>
                        <th>ZIP Code</th>
                        <td>{{ $player->municipality?->zip_code ?? 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
