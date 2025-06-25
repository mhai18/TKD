@extends('layout.master')
@section('kyorugi')
    active
@endsection
@section(section: 'APP-CONTENT')
    <div class="mb-4">
        <button type="button" class="btn btn-md btn-primary" onclick="goBack()">Go Back</button>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
    </div>
    <form id="updateForm" class="card-content needs-validation" novalidate data-id="{{ $tournament->id }}">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Tournament Information</h4>
                </div>
            </div>
            <div class="card-body">
                <!-- Profile Image Upload -->
                <div class="form-group row align-items-center">
                    <div class="col-sm-3">
                        <div class="profile-img-edit">
                            <div class="crm-profile-img-edit">
                                <img id="bannerImage" class="crm-profile-pic rounded-circle avatar-100"
                                    src="{{ asset('assets/images/user/1.jpg') }}" alt="profile-pic">
                                <div class="crm-p-image bg-primary">
                                    <label for="banner" class="upload-label" style="cursor: pointer;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </label>
                                    <input class="file-upload" type="file" name="banner" id="banner" accept="image/*"
                                        style="display: none;">
                                    <div class="invalid-feedback">Please upload a profile picture.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="name">Tournament Name:</label>
                        <input type="text" class="form-control" name="name" id="name"
                            value="{{ $tournament->name }}">
                        <div class="invalid-feedback">Tournament name is required.</div>
                    </div>
                    <div class="form-venue_name col-sm-5">
                        <label for="name">Venue Name:</label>
                        <input type="text" class="form-control" name="venue_name" id="venue_name"
                            value="{{ $tournament->venue_name }}">
                        <div class="invalid-feedback">Venue name is required.</div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="form-group col-sm-6">
                        <label for="event_category_id">Category:</label>
                        <select class="form-control choicesjs" name="event_category_id" id="event_category_id">
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($eventCategories as $eventCategory)
                                <option value="{{ $eventCategory->id }}"
                                    {{ $eventCategory->id == $tournament->event_category_id ? 'selected' : '' }}>
                                    {{ $eventCategory->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Category is required.</div>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="status">Status:</label>
                        <select class="form-control choicesjs" name="status" id="status">
                            @foreach (\App\Enums\TournamentStatus::cases() as $status)
                                <option value="{{ $status->value }}" {{ $status == $tournament->status ? 'selected' : '' }}>
                                    {{ $status->value }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please select a status.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="start_date">Start Date:</label>
                        <input type="date" class="form-control" name="start_date" id="start_date"
                            value="{{ $tournament->start_date }}">
                        <div class="invalid-feedback">Start Date is required.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="end_date">End Date:</label>
                        <input type="date" class="form-control" name="end_date" id="end_date"
                            value="{{ $tournament->end_date }}">
                        <div class="invalid-feedback">End Date is required.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="registration_start">Registration Start:</label>
                        <input type="date" class="form-control" name="registration_start" id="registration_start"
                            value="{{ $tournament->registration_start }}">
                        <div class="invalid-feedback">Registration started is required.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="registration_end">Registration End:</label>
                        <input type="date" class="form-control" name="registration_end" id="registration_end"
                            value="{{ $tournament->registration_end }}">
                        <div class="invalid-feedback">Registration started is required.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="province_code">Province:</label>
                        <select class="form-control" name="province_code" id="province_code">
                            <option value="">Select Province</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->province_code }}"
                                    {{ $tournament->province_code == $province->province_code ? 'selected' : '' }}>
                                    {{ $province->province_name }}
                                </option>
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

            $('#banner').on('change', function() {
                const input = this;
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#bannerImage').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            });

            // Remove validation error feedback on change/input/blur
            $('#updateForm').on('input change blur', 'input, select, textarea', function() {
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

            // Preselect municipality and barangay if editing
            const selectedMunicipalityCode = "{{ $tournament->municipality_code }}";
            const selectedBrgyCode = "{{ $tournament->brgy_code }}";
            const selectedProvinceCode = "{{ $tournament->province_code }}";

            // Trigger province change manually
            if (selectedProvinceCode) {
                $('#province_code').val(selectedProvinceCode).trigger('change');

                // Wait a bit for municipalities to load
                setTimeout(() => {
                    $.get(`/get-municipalities/${selectedProvinceCode}`, function(data) {
                        const municipalityChoicesArr = data.map(item => ({
                            value: item.municipality_code,
                            label: item.municipality_name,
                            selected: item.municipality_code ==
                                selectedMunicipalityCode,
                            customProperties: {
                                zip_code: item.zip_code
                            }
                        }));
                        municipalityChoices.setChoices(municipalityChoicesArr, 'value', 'label',
                            true);
                        const selectedItem = municipalityChoices.getValue();
                        const zip = selectedItem?.customProperties?.zip_code || '';
                        $('#zip_code').val(zip);

                        // Trigger municipality change to load brgys
                        setTimeout(() => {
                            $.get(`/get-brgys/${selectedMunicipalityCode}`, function(data) {
                                const brgyChoicesArr = data.map(item => ({
                                    value: item.brgy_code,
                                    label: item.brgy_name,
                                    selected: item.brgy_code ==
                                        selectedBrgyCode
                                }));
                                brgyChoices.setChoices(brgyChoicesArr, 'value',
                                    'label', true);

                                // Optional: Set ZIP code if available from selected municipality
                                const selectedItem = municipalityChoices.getValue(
                                    true);
                                const foundMunicipality = municipalityChoices
                                    .getValue()
                                    .find(item => item.value ===
                                        selectedMunicipalityCode);

                                const zip = foundMunicipality?.customProperties
                                    ?.zip_code || '';
                                $('#zip_code').val(zip);
                            });
                        }, 300);
                    });
                }, 300);
            }

            $('#updateForm').on('reset', function() {
                $(this).removeClass('was-validated');
                $(this).find('.is-invalid').removeClass('is-invalid');
                $(this).find('.invalid-feedback').hide();
                location.href = '{{ route('chapter') }}';
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

                const formData = new FormData(form);
                formData.append('_method', 'PUT');

                $.ajax({
                    method: 'POST',
                    url: `/kyorugiTournaments/${form.dataset.id}`,
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
                            location.href = '{{ route('tmKyorugi') }}'
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
