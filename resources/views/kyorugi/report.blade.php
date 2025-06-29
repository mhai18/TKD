@extends('layout.master')
@section('kyorugiReport')
    active
@endsection
@section('APP-TITLE')
    Report
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
                            <button type="button" class="mt-2 btn btn-primary reported-pill btn-with-icon" title="View"
                                onclick="showReports({{ $kyorugi->id }})">
                                <i class="fa fa-eye me-1"></i> View
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- Modal Template --}}
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="reportModalLabel">Select Report</h5>
                    <button type="button" class="btn-close text-white" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="reportList">
                    <p class="text-muted">Loading reports...</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('APP-SCRIPT')
    <script type="text/javascript">
        const reportsByTournament = [{
                label: 'Player List',
                url: 'players/export-pdf'
            },
            {
                label: 'Match Schedule',
                url: 'matches/schedule/export-pdf'
            },
            {
                label: 'Match Results',
                url: 'matches/results/export-pdf'
            },
            {
                label: 'Division Summary',
                url: 'division-summary/export-pdf'
            },
            {
                label: 'No-show Matches',
                url: 'no-shows/export-pdf'
            }
        ];

        function showReports(tournament_id) {
            const reportModal = new bootstrap.Modal(document.getElementById('reportModal'));
            const reportList = document.getElementById('reportList');
            reportList.innerHTML = '';

            reportsByTournament.forEach((report) => {
                const btn = document.createElement('button');
                btn.className = 'btn btn-outline-primary w-100 mb-2';
                btn.innerHTML = `<i class="bi bi-arrow-right-circle me-1"></i> ${report.label}`;
                btn.onclick = () => {
                    window.open(`/tournaments/${tournament_id}/${report.url}`, '_blank');
                };
                reportList.appendChild(btn);
            });

            reportModal.show();
        }
    </script>
@endsection
