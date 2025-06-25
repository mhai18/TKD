<!DOCTYPE html>
<html>

<head>
    <title>Player Performance</title>
    @include('reports.styles')
</head>

<body>
    <h2>Player Performance</h2>

    <p><strong>Total Matches:</strong> {{ $total }}</p>
    <p><strong>Wins:</strong> {{ $wins }}</p>
    <p><strong>Losses:</strong> {{ $total - $wins }}</p>

    <table>
        <thead>
            <tr>
                <th>Match</th>
                <th>Red</th>
                <th>Blue</th>
                <th>Winner</th>
                <th>Status</th>
                <th>Round</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($matches as $m)
                <tr>
                    <td>#{{ $m->id }}</td>
                    <td>{{ $m->redPlayer->full_name ?? 'TBD' }}</td>
                    <td>{{ $m->bluePlayer->full_name ?? 'TBD' }}</td>
                    <td>{{ $m->winner->full_name ?? 'TBD' }}</td>
                    <td>{{ $m->match_status }}</td>
                    <td>{{ $m->round }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
