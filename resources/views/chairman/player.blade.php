@extends('layout.master')
@section('player')
    active
@endsection
@section('APP-CONTENT')
    <div class="table-responsive">
        <table id="datatable-1" class="table data-table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Avatar</th>
                    <th>Member ID</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($players as $player)
                    <tr>
                        <td>{{ $player->id }}</td>
                        <td>
                            <img src="{{ $player->user->getFirstMediaUrl('avatar', 'thumb') ?: asset('assets/images/user/1.jpg') }}"
                                alt="Avatar" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td>{{ $player->member_id }}</td>
                        <td>{{ $player->user->full_name }}</td>
                        <td>{{ $player->gender }}</td>
                        <td>{{ $player->full_address }}</td>
                        <td>
                            <button type="button" class="mt-2 btn btn-primary rounded-pill btn-with-icon" title="Edit"
                                onclick="view({{ $player->id }})">
                                <i class="fa fa-eye">View</i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('APP-SCRIPT')
    <script type="text/javascript">
        function view(player_id) {
            window.location.href = `/chairman/viewPlayer/${player_id}`;
        }

        $(document).ready(function() {

        });
    </script>
@endsection
