@extends('layout.master')
@section('chapter')
    active
@endsection
@section('APP-CONTENT')
    <form id="addForm" class="card-content needs-validation" novalidate>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Chapter Information</h4>
                </div>
            </div>
            <div class="card-body">

                <!-- Personal Information -->
                <div class="row align-items-center">
                    <div class="form-group col-sm-12">
                        <label for="chapter_name">Chapter Name:</label>
                        <input type="text" class="form-control" name="chapter_name" id="chapter_name">
                        <div class="invalid-feedback">Chapter name is required.</div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="date_started">Date Started:</label>
                        <input type="date" class="form-control" name="date_started" id="date_started">
                        <div class="invalid-feedback">Date started is required.</div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="coach_id">Committee:</label>
                        <select class="form-control choicesjs" name="coach_id" id="coach_id">
                            @foreach ($committees as $committee)
                                @if ($committee->user->user_type == \App\Enums\UserType::COACH)
                                    <option value="{{ $committee->user->id }}">{{ ucwords($committee->user->full_name) }}
                                    </option>
                                @endif
                            @endforeach

                        </select>
                        <div class="invalid-feedback">Please select a user types.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="province_code">Province:</label>
                        <select class="form-control" name="province_code" id="province_code">
                            <option value="">Select Province</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->province_code }}">{{ $province->province_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Province is required.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="municipality_code">Municipality:</label>
                        <select class="form-control" name="municipality_code" id="municipality_code">
                            <option value="">Select Municipality</option>
                        </select>
                        <div class="invalid-feedback">Municipality is required.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="brgy_code">Barangay:</label>
                        <select class="form-control" name="brgy_code" id="brgy_code">
                            <option value="">Select Barangay</option>
                        </select>
                        <div class="invalid-feedback">Barangay is required.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="zip_code">ZIP Code:</label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code" readonly>
                        <div class="invalid-feedback">ZIP Code will auto-fill based on barangay.</div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-outline-primary mr-2">Cancel</button>
            </div>
        </div>
    </form>
@endsection
@section('APP-SCRIPT')
    <script type="text/javascript">
        $(document).ready(function() {
            const provinceChoices = new Choices('#province_code', {
                shouldSort: false
            });
            const municipalityChoices = new Choices('#municipality_code', {
                shouldSort: false
            });
            const brgyChoices = new Choices('#brgy_code', {
                shouldSort: false
            });

            $('#province_code').on('change', function() {
                const provinceCode = $(this).val();

                municipalityChoices.clearStore();
                municipalityChoices.setChoices([{
                    value: '',
                    label: 'Select Municipality',
                    selected: true
                }], 'value', 'label', true);
                brgyChoices.clearStore();
                brgyChoices.setChoices([{
                    value: '',
                    label: 'Select Barangay',
                    selected: true
                }], 'value', 'label', true);
                $('#zip_code').val('');

                if (provinceCode) {
                    $.get(`/get-municipalities/${provinceCode}`, function(data) {
                        const newChoices = data.map(item => ({
                            value: item.municipality_code,
                            label: item.municipality_name,
                            customProperties: {
                                zip_code: item.zip_code
                            }
                        }));
                        municipalityChoices.setChoices(newChoices, 'value', 'label', true);
                    });
                }
            });

            $('#municipality_code').on('change', function() {
                const selectedOption = municipalityChoices.getValue(true); // gets selected value
                const selectedItem = municipalityChoices
                    .getValue(); // gets selected item with custom properties

                $('#brgy_code').empty();
                brgyChoices.clearStore();
                brgyChoices.setChoices([{
                    value: '',
                    label: 'Select Barangay',
                    selected: true
                }], 'value', 'label', true);
                $('#zip_code').val(''); // reset zip

                if (selectedOption) {
                    // Get zip code from custom properties
                    const zip = selectedItem?.customProperties?.zip_code || '';
                    $('#zip_code').val(zip);

                    $.get(`/get-brgys/${selectedOption}`, function(data) {
                        const newChoices = data.map(item => ({
                            value: item.brgy_code,
                            label: item.brgy_name
                        }));
                        brgyChoices.setChoices(newChoices, 'value', 'label', true);
                    });
                }
            });

            $('#avatar').on('change', function() {
                const input = this;
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#profileImage').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            });

            // Remove validation error feedback on change/input/blur
            $('#addForm').on('input change blur', 'input, select, textarea', function() {
                const $input = $(this);

                // For radio buttons: clear all in the same group
                if ($input.attr('type') === 'radio') {
                    const name = $input.attr('name');
                    $(`input[name="${name}"]`).removeClass('is-invalid');
                    $input.closest('.form-group').find('.invalid-feedback').hide();
                }
                // For checkboxes
                else if ($input.attr('type') === 'checkbox') {
                    $input.removeClass('is-invalid');
                    $input.closest('.form-group').find('.invalid-feedback').hide();
                }
                // For select, file, others
                else {
                    $input.removeClass('is-invalid');
                    if ($input.is('select') || $input.attr('type') === 'file') {
                        $input.closest('.form-group').find('.invalid-feedback').hide();
                    } else {
                        $input.next('.invalid-feedback').hide();
                    }
                }
            });

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

                const formData = new FormData(form);

                $.ajax({
                    method: 'POST',
                    url: '/chapters',
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
                            location.href = '{{ route('chapter') }}'
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

                                    // Handle select or file input differently if needed
                                    if ($input.is('select') || $input.attr('type') === 'file') {
                                        $input.closest('.form-group').find('.invalid-feedback')
                                            .text(errors[field][0]).show();
                                    } else if ($input.attr('type') === 'radio' || $input.attr(
                                            'type') === 'checkbox') {
                                        $input.closest('.form-group').find('.invalid-feedback')
                                            .text(errors[field][0]).show();
                                    } else {
                                        $input.next('.invalid-feedback').text(errors[field][0])
                                            .show();
                                    }
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
