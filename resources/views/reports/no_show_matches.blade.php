<!DOCTYPE html>
<html>

<head>
    <title>No-show / Walkover Matches</title>
    @include('reports.styles')
</head>

<body>
    <h2>No-show Matches - Tournament #{{ $tournamentId }}</h2>
    <table>
        <thead>
            <tr>
                <th>Match ID</th>
                <th>Red</th>
                <th>Blue</th>
                <th>Winner</th>
                <th>Round</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($matches as $m)
                <tr>
                    <td>{{ $m->id }}</td>
                    <td>{{ $m->redPlayer->full_name ?? 'BYE' }}</td>
                    <td>{{ $m->bluePlayer->full_name ?? 'BYE' }}</td>
                    <td>{{ $m->winner->full_name ?? 'Pending' }}</td>
                    <td>{{ $m->round }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
