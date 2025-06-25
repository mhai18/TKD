<!DOCTYPE html>
<html>

<head>
    <title>Division Summary</title>
    @include('reports.styles')
</head>

<body>
    <h2>Division Summary - Tournament #{{ $tournamentId }}</h2>
    <table>
        <thead>
            <tr>
                <th>Division</th>
                <th>Weight</th>
                <th>Belt</th>
                <th>Gender</th>
                <th>Players</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($summary as $s)
                <tr>
                    <td>{{ $s->division }}</td>
                    <td>{{ $s->weight_class }}</td>
                    <td>{{ $s->belt_level }}</td>
                    <td>{{ $s->gender }}</td>
                    <td>{{ $s->total_players }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
