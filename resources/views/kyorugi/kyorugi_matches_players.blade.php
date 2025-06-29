@extends('layout.master')
@section('kyorugiMatches')
    active
@endsection
@section('APP-TITLE')
    Kyorugi Matches Player
@endsection
@section('APP-CONTENT')
    <div class="table-responsive">
        <table id="datatable-1" class="table data-table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Red Player</th>
                    <th>Start Date</th>
                    <th>End Date</th>
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
                        <td>{{ $kyorugi->venue_name }}</td>
                        <td>{{ $kyorugi->full_address }}</td>
                        <td>{{ $kyorugi->status }}</td>
                        <td>
                            <button type="button" class="mt-2 btn btn-primary rounded-pill btn-with-icon" title="View"
                                onclick="view({{ $kyorugi->id }})">
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
        function view(tournament_id) {
            window.location.href = `/tm/kyorugiBracket/${tournament_id}`;
        }

        $(document).ready(function() {

        });
    </script>
@endsection
