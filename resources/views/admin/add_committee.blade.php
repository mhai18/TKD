@extends('layout.master')
@section('committee')
    active
@endsection
@section('APP-CONTENT')
    <form id="addForm" class="card-content needs-validation" novalidate>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Committee Information</h4>
                </div>
            </div>
            <div class="card-body">
                <!-- Profile Image Upload -->
                <div class="form-group row align-items-center">
                    <div class="col-sm-3">
                        <div class="profile-img-edit">
                            <div class="crm-profile-img-edit">
                                <img id="profileImage" class="crm-profile-pic rounded-circle avatar-100"
                                    src="{{ asset('assets/images/user/1.jpg') }}" alt="profile-pic">
                                <div class="crm-p-image bg-primary">
                                    <label for="avatar" class="upload-label" style="cursor: pointer;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </label>
                                    <input class="file-upload" type="file" name="avatar" id="avatar" accept="image/*"
                                        style="display: none;">
                                    <div class="invalid-feedback">Please upload a profile picture.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="member_id">Member ID:</label>
                        <input type="text" class="form-control" name="member_id" id="member_id">
                        <div class="invalid-feedback">Member ID is required.</div>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="pta_id">PTA ID:</label>
                        <input type="text" class="form-control" name="pta_id" id="pta_id">
                        <div class="invalid-feedback">PTA ID is required.</div>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="ncc_id">NCC ID:</label>
                        <input type="text" class="form-control" name="ncc_id" id="ncc_id">
                        <div class="invalid-feedback">NCC ID is required.</div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="row align-items-center">
                    <div class="header-title col-sm-12">
                        <h4 class="card-title">Personal Information</h4>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="first_name">First Name:</label>
                        <input type="text" class="form-control" name="first_name" id="first_name">
                        <div class="invalid-feedback">First name is required.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="middle_name">Middle Name:</label>
                        <input type="text" class="form-control" name="middle_name" id="middle_name">
                        <div class="invalid-feedback">Middle name is optional.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="last_name">Last Name:</label>
                        <input type="text" class="form-control" name="last_name" id="last_name">
                        <div class="invalid-feedback">Last name is required.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="extension_name">Extension Name:</label>
                        <input type="text" class="form-control" name="extension_name" id="extension_name">
                        <div class="invalid-feedback">Extension name is optional.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="contact_number">Contact Number:</label>
                        <input type="tel" class="form-control" name="contact_number" id="contact_number">
                        <div class="invalid-feedback">Contact number is required.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="email">Email Address:</label>
                        <input type="email" class="form-control" name="email" id="email">
                        <div class="invalid-feedback">Email is required.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="birth_date">Birth Date:</label>
                        <input type="date" class="form-control" name="birth_date" id="birth_date">
                        <div class="invalid-feedback">Birth date is required.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label class="d-block">Gender:</label>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="gender1" name="gender" class="custom-control-input"
                                value="Male">
                            <label class="custom-control-label" for="gender1"> Male </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="gender2" name="gender" class="custom-control-input"
                                value="Female">
                            <label class="custom-control-label" for="gender2"> Female </label>
                        </div>
                        <div class="invalid-feedback d-block">Please select a gender.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="civil_status">Civil Status:</label>
                        <select class="form-control choicesjs" name="civil_status" id="civil_status">
                            @foreach (\App\Enums\CivilStatus::cases() as $status)
                                <option value="{{ $status->value }}">{{ $status->value }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please select a civil status.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="religion">Religion:</label>
                        <select class="form-control choicesjs" name="religion" id="religion">
                            @foreach (\App\Enums\Religion::cases() as $religion)
                                <option value="{{ $religion->value }}">{{ $religion->value }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please select a religion.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="belt_level">Belt Level:</label>
                        <select class="form-control choicesjs" name="belt_level" id="belt_level">
                            @foreach (\App\Enums\BeltLevel::cases() as $belt)
                                <option value="{{ $belt->value }}">{{ ucwords($belt->value) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please select a belt level.</div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="user_type">User Types:</label>
                        <select class="form-control choicesjs" name="user_type" id="user_type">
                            @foreach (\App\Enums\UserType::cases() as $user)
                                @if ($user->value !== 'Player' && $user->value !== 'Admin')
                                    <option value="{{ $user->value }}" selected>{{ ucwords($user->value) }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please select a user types.</div>
                    </div>

                    <!-- Address Info -->
                    <div class="header-title col-sm-12">
                        <h4 class="card-title">Address Information</h4>
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
                    url: '/committees',
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
                            location.href = '{{ route('committee') }}';
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
