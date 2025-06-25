<!DOCTYPE html>
<html>

<head>
    <title>Match Schedule</title>
    @include('reports.styles')
</head>

<body>
    <h2>Match Schedule - Tournament #{{ $tournamentId }}</h2>
    <table>
        <thead>
            <tr>
                <th>Round</th>
                <th>Date/Time</th>
                <th>Red Player</th>
                <th>Blue Player</th>
                <th>Division</th>
                <th>Weight</th>
                <th>Belt</th>
                <th>Gender</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($matches as $m)
                <tr>
                    <td>{{ $m->round }}</td>
                    <td>{{ $m->match_datetime }}</td>
                    <td>{{ $m->redPlayer->full_name ?? 'TBD' }}</td>
                    <td>{{ $m->bluePlayer->full_name ?? 'TBD' }}</td>
                    <td>{{ $m->division }}</td>
                    <td>{{ $m->weight_class }}</td>
                    <td>{{ $m->belt_level }}</td>
                    <td>{{ $m->gender }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
