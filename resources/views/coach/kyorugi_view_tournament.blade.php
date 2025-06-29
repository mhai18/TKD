@extends('layout.master')
@section('kyorugiPlayer')
    active
@endsection
@section('APP-TITLE')
    Kyorugi View Tournament
@endsection
@section('APP-CONTENT')
    <div class="table-responsive">
        <table id="datatable-1" class="table data-table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Avatar</th>
                    <th>Player Name</th>
                    <th>Chapter Name</th>
                    <th>Belt Level</th>
                    <th>Gender</th>
                    <th>Division</th>
                    <th>Weight Class</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kyorugis as $kyorugi)
                    <tr>
                        <td>{{ $kyorugi->id }}</td>
                        <td>
                            <img src="{{ $kyorugi->player->getFirstMediaUrl('avatar', 'thumb') ?: asset('assets/images/user/1.jpg') }}"
                                alt="Avatar" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td>{{ $kyorugi->player->full_name }}</td>
                        <td>{{ $kyorugi->registeredBy->chapter->chapter_name }}</td>
                        <td>{{ $kyorugi->player->player->belt_level }}</td>
                        <td>{{ $kyorugi->player->player->gender }}</td>
                        <td>{{ $kyorugi->division }}</td>
                        <td>{{ $kyorugi->weight_class }} Weight</td>
                        <td>
                            <button type="button" class="mt-2 btn btn-primary rounded-pill btn-with-icon" title="View"
                                onclick="view({{ $kyorugi->player->player->id }})">
                                <i class="fa fa-edit">View</i>
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
        function view(playerID) {
            window.location.href = `/coach/viewPlayer/${playerID}`;
        }

        $(document).ready(function() {

        });
    </script>
@endsection
