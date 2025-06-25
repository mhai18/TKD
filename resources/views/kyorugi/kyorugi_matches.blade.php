@extends('layout.master')
@section('kyorugiMatches')
    active
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
                            <button type="button" class="mt-2 btn btn-primary rounded-pill btn-with-icon" title="View"
                                onclick="showRounds({{ $kyorugi->id }})">
                                <i class="fa fa-eye me-1"></i> View
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- Modal Template --}}
    <div class="modal fade" id="roundModal" tabindex="-1" aria-labelledby="roundModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="roundModalLabel">Select Round</h5>
                    <button type="button" class="btn-close text-white" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="roundList">
                    <p class="text-muted">Loading rounds...</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('APP-SCRIPT')
    <script type="text/javascript">
        const roundsByTournament = @json($roundsByTournament);
        const showSummaryButton = @json($showSummaryButton);

        function showRounds(tournament_id) {
            const roundModal = new bootstrap.Modal(document.getElementById('roundModal'));
            const roundList = document.getElementById('roundList');
            roundList.innerHTML = '';

            const rounds = roundsByTournament[tournament_id];

            if (!rounds || rounds.length === 0) {
                roundList.innerHTML = `<div class="alert alert-warning">No rounds available for this tournament.</div>`;
            } else {
                rounds.forEach((match, index) => {
                    const btn = document.createElement('button');
                    btn.className = 'btn btn-outline-primary w-100 mb-2';
                    btn.innerHTML = `<i class="bi bi-arrow-right-circle me-1"></i> Round ${match.round}`;
                    btn.onclick = () => {
                        window.location.href = `/tm/kyorugiBracket/${tournament_id}?round=${match.round}`;
                    };
                    roundList.appendChild(btn);
                });

                if (showSummaryButton[tournament_id]) {
                    const summaryBtn = document.createElement('button');
                    summaryBtn.className = 'btn btn-success w-100 mt-3';
                    summaryBtn.innerHTML = `<i class="bi bi-trophy me-1"></i> View Tournament Summary`;
                    summaryBtn.onclick = () => {
                        window.location.href = `/tm/kyorugiSummary/${tournament_id}`;
                    };
                    roundList.appendChild(summaryBtn);
                }
            }

            roundModal.show();
        }
    </script>
@endsection
