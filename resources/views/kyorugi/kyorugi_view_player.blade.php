@extends('layout.master')
@section('kyorugiPlayer')
    active
@endsection
@section('APP-CONTENT')
    <div class="table-responsive">
        @if (!$hasMatches)
            <div class="text-right mb-3">
                <button type="button" onclick="generateMatch({{ $tournamentID }})" class="btn btn-md btn-primary">Generate
                    Match</button>
            </div>
        @endif
        <table id="datatable-1" class="table data-table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Avatar</th>
                    <th>Player Name</th>
                    <th>Chapter Name</th>
                    <th>Belt Level</th>
                    <th>Gender</th>
                    <th>Division</th>
                    <th>Weight Class</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kyorugis as $kyorugi)
                    <tr>
                        <td>{{ $kyorugi->id }}</td>
                        <td>
                            <img src="{{ $kyorugi->player->getFirstMediaUrl('avatar', 'thumb') ?: asset('assets/images/user/1.jpg') }}"
                                alt="Avatar" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td>{{ $kyorugi->player->full_name }}</td>
                        <td>{{ $kyorugi->registeredBy->chapter->chapter_name }}</td>
                        <td>{{ $kyorugi->player->player->belt_level }}</td>
                        <td>{{ $kyorugi->player->player->gender }}</td>
                        <td>{{ $kyorugi->division }}</td>
                        <td>{{ $kyorugi->weight_class }} Weight</td>
                        <td>
                            <button type="button" class="mt-2 btn btn-primary rounded-pill btn-with-icon" title="View"
                                onclick="view({{ $kyorugi->player->player->id }})">
                                <i class="fa fa-edit">View</i>
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
        function view(player_id) {
            window.location.href = `/tm/viewPlayer/${player_id}`;
        }

        function generateMatch(tournamentID) {
            $.ajax({
                method: 'POST',
                url: '/kyorugiTournamentMatches',
                data: {
                    tournament_id: tournamentID,
                },
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    console.log('✅ Success:', response.message);
                    console.log('👤 Player:', response.data);
                    showDatumAlert('success', response.message);

                    setTimeout(() => {
                        location.href = '{{ route('tmKyorugiMatches') }}'
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
        }

        $(document).ready(function() {

        });
    </script>
@endsection
