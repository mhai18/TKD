@extends('layout.master')
@section('committee')
    active
@endsection
@section('APP-TITLE')
    Committee
@endsection
@section('APP-CONTENT')
    <div class="table-responsive">
        <div class="text-right mb-3">
            <a href="{{ route('addCommittee') }}" class="btn btn-md btn-primary">Add New Committee</a>
        </div>
        <table id="datatable-1" class="table data-table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Avatar</th>
                    <th>Member ID</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($committees as $committee)
                    <tr>
                        <td>{{ $committee->id }}</td>

                        <td>
                            <img src="{{ $committee->user->getFirstMediaUrl('avatar', 'thumbnail') ?: asset('assets/images/user/1.jpg') }}"
                                alt="Avatar" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                        </td>

                        <td>{{ $committee->member_id }}</td>
                        <td>{{ $committee->user->full_name }}</td>

                        <td>{{ $committee->user->user_type }}</td>
                        <td>{{ $committee->gender }}</td>
                        <td>{{ $committee->full_address }}</td>

                        <td>
                            <button type="button" class="mt-2 btn btn-primary rounded-pill btn-with-icon" title="Edit"
                                onclick="edit({{ $committee->id }})">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button type="button" class="mt-2 btn btn-danger rounded-pill btn-with-icon" title="Delete"
                                onclick="remove({{ $committee->id }})">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </td>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('APP-SCRIPT')
    <script type="text/javascript">
        function edit(committee_id) {
            window.location.href = `/committees/${committee_id}`;
        }

        function remove(committee_id) {
            $.ajax({
                method: 'DELETE',
                url: `/committees/${committee_id}`,
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
