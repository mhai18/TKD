@extends('layout.master')
@section('player')
    active
@endsection
@section('APP-CONTENT')
    <div class="table-responsive">
        <div class="text-right mb-3">
            <a href="{{ route('addPlayer') }}" class="btn btn-md btn-primary">Add New Player</a>
        </div>
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
                            <img src="{{ $player->user->getFirstMediaUrl('avatar', 'thumbnail') ?: asset('assets/images/user/1.jpg') }}"
                                alt="Avatar" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td>{{ $player->member_id }}</td>
                        <td>{{ $player->user->full_name }}</td>
                        <td>{{ $player->gender }}</td>
                        <td>{{ $player->full_address }}</td>
                        <td>
                            <button type="button" class="mt-2 btn btn-primary rounded-pill btn-with-icon" title="Edit"
                                onclick="edit({{ $player->id }})">
                                <i class="fa fa-edit">Edit</i>
                            </button>
                            <button type="button" class="mt-2 btn btn-danger rounded-pill btn-with-icon" title="Delete"
                                onclick="remove({{ $player->id }})">
                                <i class="fa fa-trash">Delete</i>
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
        function edit(player_id) {
            window.location.href = `/players/${player_id}`;
        }

        function remove(player_id) {
            $.ajax({
                method: 'DELETE',
                url: `/players/${player_id}`,
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    showDatumAlert('success', response.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                },
                error: function(response) {
                    showDatumAlert('danger', response.responseJSON?.message ||
                        'Unexpected server error.');
                    console.error('Full error:', response.responseJSON);
                }
            });
        }
        $(document).ready(function() {

        });
    </script>
@endsection
