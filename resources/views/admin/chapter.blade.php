@extends('layout.master')
@section('chapter')
    active
@endsection
@section('APP-TITLE')
    Chapter
@endsection
@section('APP-CONTENT')
    <div class="table-responsive">
        <div class="text-right mb-3">
            <a href="{{ route('addChapter') }}" class="btn btn-md btn-primary">Add New Chapter</a>
        </div>
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
                                onclick="edit({{ $chapter->id }})">
                                <i class="fa fa-edit">Edit</i>
                            </button>
                            <button type="button" class="mt-2 btn btn-danger rounded-pill btn-with-icon" title="Delete"
                                onclick="remove({{ $chapter->id }})">
                                <i class="fa fa-trash">Delete</i>
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
        function edit(chapter_id) {
            window.location.href = `/chapters/${chapter_id}`;
        }

        function remove(chapter_id) {
            $.ajax({
                method: 'DELETE',
                url: `/chapters/${chapter_id}`,
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    showDatumAlert('success', response.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                },
                error: function(response) {
                    showDatumAlert('danger', response.responseJSON?.message ||
                        'Unexpected server error.');
                    console.error('Full error:', response.responseJSON);
                }
            });
        }

        $(document).ready(function() {

        });
    </script>
@endsection
