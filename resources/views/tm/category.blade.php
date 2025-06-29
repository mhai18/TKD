@extends('layout.master')
@section('event')
    active
@endsection
@section('APP-TITLE')
    Category
@endsection
@section('APP-CONTENT')
    <div class="table-responsive">
        <div class="text-right mb-3">
            <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#addEventCategory">Add New
                Category</button>
        </div>
        <table id="datatable-1" class="table data-table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Date Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eventCategories as $eventCategory)
                    <tr>
                        <td>{{ $eventCategory->id }}</td>
                        <td>{{ $eventCategory->name }}</td>
                        <td>{{ date('F j, Y', strtotime($eventCategory->created_at)) }}</td>
                        <td>
                            <button type="button" class="mt-2 btn btn-primary rounded-pill btn-with-icon" title="Edit"
                                onclick="edit({{ $eventCategory->id }})">
                                <i class="fa fa-edit">Edit</i>
                            </button>
                            <button type="button" class="mt-2 btn btn-danger rounded-pill btn-with-icon" title="Delete"
                                onclick="remove({{ $eventCategory->id }})">
                                <i class="fa fa-trash">Delete</i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="addEventCategory" tabindex="-1" role="dialog" aria-labelledby="addEventCategoryLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="addForm" class="modal-content needs-validation" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventCategoryLabel">Event Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" id="name">
                        <div class="invalid-feedback">Name is required.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="updateEventCategory" tabindex="-1" role="dialog"
        aria-labelledby="updateEventCategoryLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="updateForm" class="modal-content needs-validation" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title" id="updateEventCategoryLabel">Update Event Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" id="name">
                        <div class="invalid-feedback">Name is required.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('APP-SCRIPT')
    <script type="text/javascript">
        let eventCategoryID;

        function edit(eventCategory_id) {
            $.ajax({
                method: 'GET',
                url: `/eventCategories/${eventCategory_id}`,
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    console.log('✅ Success:', response.message);
                    console.log('👤 Player:', response.data);

                    eventCategoryID = eventCategory_id;

                    $('#updateForm').find('input[name="name"]').val(response.data.name);

                    $('#updateEventCategory').modal('show');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let errorList = '';
                        for (let field in errors) {
                            errorList += `${field}: ${errors[field].join(', ')}\n`;
                        }
                        showDatumAlert('danger', 'Validation Error:\n' + errorList);
                    } else {
                        showDatumAlert('danger', xhr.responseJSON?.message ||
                            'Unexpected server error.');
                        console.error('Full error:', xhr.responseJSON);
                    }
                }
            });
        }

        function remove(eventCategory_id) {
            $.ajax({
                method: 'DELETE',
                url: `/eventCategories/${eventCategory_id}`,
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


            $('#addForm').on('reset', function() {
                $(this).removeClass('was-validated');
                $(this).find('.is-invalid').removeClass('is-invalid');
                $(this).find('.invalid-feedback').hide();
            });

            $('#addForm').submit(function(event) {
                event.preventDefault();

                const form = this;

                // Add Bootstrap's validation class
                $(form).addClass('was-validated');

                // Prevent submission if form is invalid
                if (!form.checkValidity()) {
                    return false;
                }

                $('#addEventCategory').modal('hide');

                const formData = new FormData(form);

                $.ajax({
                    method: 'POST',
                    url: '/eventCategories',
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        console.log('✅ Success:', response.message);
                        console.log('👤 Player:', response.data);
                        showDatumAlert('success', response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorList = '';
                            for (let field in errors) {
                                errorList += `${field}: ${errors[field].join(', ')}\n`;

                                // Optionally show error beside the field
                                const $input = $(`[name="${field}"]`);

                                if ($input.length) {
                                    $input.addClass('is-invalid');
                                    $input.prop('required', true);

                                    $input.next('.invalid-feedback').text(errors[field][0])
                                        .show();
                                }
                            }
                            showDatumAlert('danger', 'Validation Error:\n' + errorList);
                        } else {
                            showDatumAlert('danger', xhr.responseJSON?.message ||
                                'Unexpected server error.');
                            console.error('Full error:', xhr.responseJSON);
                        }
                    }
                });
            });


            $('#updateForm').on('reset', function() {
                $(this).removeClass('was-validated');
                $(this).find('.is-invalid').removeClass('is-invalid');
                $(this).find('.invalid-feedback').hide();
            });

            $('#updateForm').submit(function(event) {
                event.preventDefault();

                const form = this;

                // Add Bootstrap's validation class
                $(form).addClass('was-validated');

                // Prevent submission if form is invalid
                if (!form.checkValidity()) {
                    return false;
                }

                $('#updateEventCategory').modal('hide');

                $.ajax({
                    method: 'PUT',
                    url: `/eventCategories/${eventCategoryID}`,
                    data: $('#updateForm').serialize(),
                    dataType: 'JSON',
                    cache: false,
                    success: function(response) {
                        console.log('✅ Success:', response.message);
                        console.log('👤 Player:', response.data);
                        showDatumAlert('success', response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorList = '';
                            for (let field in errors) {
                                errorList += `${field}: ${errors[field].join(', ')}\n`;

                                // Optionally show error beside the field
                                const $input = $(`[name="${field}"]`);

                                if ($input.length) {
                                    $input.addClass('is-invalid');
                                    $input.prop('required', true);

                                    $input.next('.invalid-feedback').text(errors[field][0])
                                        .show();
                                }
                            }
                            showDatumAlert('danger', 'Validation Error:\n' + errorList);
                        } else {
                            showDatumAlert('danger', xhr.responseJSON?.message ||
                                'Unexpected server error.');
                            console.error('Full error:', xhr.responseJSON);
                        }
                    }
                });
            });
        });
    </script>
@endsection
