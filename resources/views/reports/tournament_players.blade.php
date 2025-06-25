<!DOCTYPE html>
<html>

<head>
    <title>Tournament Player List</title>
    @include('reports.styles')
</head>

<body>
    <h2>Player List - Tournament #{{ $tournamentId }}</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Division</th>
                <th>Weight</th>
                <th>Belt</th>
                <th>Gender</th>
                <th>Status</th>
                <th>Coach</th>
                <th>Chapter</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($players as $p)
                <tr>
                    <td>{{ $p->player->full_name }}</td>
                    <td>{{ $p->division }}</td>
                    <td>{{ $p->weight_class }}</td>
                    <td>{{ $p->belt_level }}</td>
                    <td>{{ $p->gender }}</td>
                    <td>{{ $p->status }}</td>
                    <td>{{ $p->registeredBy->full_name }}</td>
                    <td>{{ $p->registeredBy->chapter->chapter_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
