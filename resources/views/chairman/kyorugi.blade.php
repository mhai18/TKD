@extends('layout.master')
@section('kyorugi')
    active
@endsection
@section('APP-TITLE')
    Kyorugi
@endsection
@section('APP-CONTENT')
    <div class="table-responsive">
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('APP-SCRIPT')
    <script type="text/javascript">
        function register(tournament_id) {
            window.location.href = `/coach/kyorugiPlayer/${tournament_id}`;
        }

        $(document).ready(function() {

        });
    </script>
@endsection
