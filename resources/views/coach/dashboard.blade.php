<!-- Blade Template (resources/views/coach/dashboard.blade.php) -->
@extends('layout.master')

@section('APP-TITLE')
    Dashboard | Coach
@endsection

@section('APP-CSS')
    <style>
        .radio {
            margin-right: 15px;
        }
    </style>
@endsection

@section('APP-CONTENT')
    <h1>Coach Dashboard</h1>
    <!-- Add your dashboard content here -->
@endsection

@section('APP-SCRIPT')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            var chapter = "{{ $chapter ?? '' }}";

            if (!chapter) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Chapter Assigned',
                    text: 'You need to select a chapter to proceed.',
                    confirmButtonText: 'Logout',
                    allowOutsideClick: false,
                    preConfirm: () => {
                        window.location.href = "{{ route('signout') }}";
                    }
                });
            }
        });
    </script>
@endsection
