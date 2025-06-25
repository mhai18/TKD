@extends('layout.master')
@section('kyorugi')
    active
@endsection
@section('APP-CONTENT')
    <div class="table-responsive">
        <div class="text-right mb-3">
            <a href="{{ route('addKyorugi') }}" class="btn btn-md btn-primary">Add New Tournament</a>
        </div>
        <table id="datatable-1" class="table data-table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Registration Start</th>
                    <th>Registration End</th>
                    <th>Venue</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kyorugis as $kyorugi)
                    <tr>
                        <td>{{ $kyorugi->id }}</td>
                        <td>{{ $kyorugi->name }}</td>
                        <td>{{ date('F j, Y', strtotime($kyorugi->start_date)) }}</td>
                        <td>{{ date('F j, Y', strtotime($kyorugi->end_date)) }}</td>
                        <td>{{ date('F j, Y', strtotime($kyorugi->registration_start)) }}</td>
                        <td>{{ date('F j, Y', strtotime($kyorugi->registration_end)) }}</td>
                        <td>{{ $kyorugi->venue_name }}</td>
                        <td>{{ $kyorugi->full_address }}</td>
                        <td>{{ $kyorugi->status }}</td>
                        <td>
                            <button type="button" class="mt-2 btn btn-primary rounded-pill btn-with-icon" title="Edit"
                                onclick="edit({{ $kyorugi->id }})">
                                <i class="fa fa-edit">Edit</i>
                            </button>
                            <button type="button" class="mt-2 btn btn-danger rounded-pill btn-with-icon" title="Delete"
                                onclick="remove({{ $kyorugi->id }})">
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
        function edit(tournament_id) {
            window.location.href = `/kyorugiTournaments/${tournament_id}`;
        }

        function remove(tournament_id) {
            $.ajax({
                method: 'DELETE',
                url: `/kyorugiTournaments/${tournament_id}`,
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
