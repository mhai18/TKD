<!DOCTYPE html>
<html>

<head>
    <title>Match Results</title>
    @include('reports.styles')
</head>

<body>
    <h2>Match Results - Tournament #{{ $tournamentId }}</h2>
    <table>
        <thead>
            <tr>
                <th>Round</th>
                <th>Date</th>
                <th>Red</th>
                <th>Blue</th>
                <th>Winner</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($matches as $m)
                <tr>
                    <td>{{ $m->round }}</td>
                    <td>{{ $m->match_datetime }}</td>
                    <td>{{ $m->redPlayer->full_name ?? '-' }}</td>
                    <td>{{ $m->bluePlayer->full_name ?? '-' }}</td>
                    <td>{{ $m->winner->full_name ?? 'Pending' }}</td>
                    <td>{{ $m->match_status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
