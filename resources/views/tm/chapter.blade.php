@extends('layout.master')
@section('chapter')
    active
@endsection
@section('APP-CONTENT')
    <div class="table-responsive">
        <table id="datatable-1" class="table data-table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Chapter Name</th>
                    <th>Committee Name</th>
                    <th>Address</th>
                    <th>Date Started</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chapters as $chapter)
                    <tr>
                        <td>{{ $chapter->id }}</td>
                        <td>{{ $chapter->chapter_name }}</td>
                        <td>{{ $chapter->coach->full_name }}</td>
                        <td>{{ $chapter->full_address }}</td>
                        <td>{{ date('F j, Y', strtotime($chapter->date_started)) }}</td>
                        <td>
                            <button type="button" class="mt-2 btn btn-primary rounded-pill btn-with-icon" title="Edit"
                                onclick="view({{ $chapter->id }})">
                                <i class="fa fa-eye">View</i>
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
        function view(chapter_id) {
            window.location.href = `/tm/viewChapter/${chapter_id}`;
        }

        $(document).ready(function() {

        });
    </script>
@endsection
