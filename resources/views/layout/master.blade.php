<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TKD | @yield('APP-TITLE')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />

    <link rel="stylesheet" href="{{ asset('assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @yield('APP-CSS')
</head>

<body class="color-light">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">
        <div class="iq-sidebar  sidebar-default  ">
            <div class="iq-sidebar-logo d-flex align-items-end justify-content-between">
                <a href="#" class="header-logo">
                    <img src="{{ asset('assets/images/taekwondo_light.png') }}"
                        class="img-fluid rounded-normal light-logo" alt="logo">
                    <img src="{{ asset('assets/images/taekwondo_dark.png') }}"
                        class="img-fluid rounded-normal d-none sidebar-light-img" alt="logo">
                    <span>Taekwondo</span>
                </a>
                <div class="side-menu-bt-sidebar-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-light wrapper-menu" width="30"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
            <div class="data-scrollbar" data-scroll="1">
                @php
                    $userType = strtolower(auth()->user()->user_type->value);
                    if ($userType == 'tournament manager') {
                        $userType = 'tm';
                    }
                @endphp

                @includeIf($userType . '.sidebar')

                <div class="pt-5 pb-5"></div>
            </div>
        </div>
        <div class="iq-top-navbar">
            <div class="iq-navbar-custom">
                @include('layout.navbar')
            </div>
        </div>
        <div class="content-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="alert-container" class="mt-4"></div>
                    </div>
                    <div class="col-lg-12">
                        @yield('APP-CONTENT')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Wrapper End-->
    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('assets/js/backend-bundle.min.js') }}"></script>
    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('assets/js/customizer.js') }}"></script>

    <script src="{{ asset('assets/js/sidebar.js') }}"></script>

    <!-- Flextree Javascript-->
    <script src="{{ asset('assets/js/flex-tree.min.js') }}"></script>
    <script src="{{ asset('assets/js/tree.js') }}"></script>

    <!-- Table Treeview JavaScript -->
    <script src="{{ asset('assets/js/table-treeview.js') }}"></script>

    <!-- SweetAlert JavaScript -->
    <script src="{{ asset('assets/js/sweetalert.js') }}"></script>

    <!-- Vectoe Map JavaScript -->
    <script src="{{ asset('assets/js/vector-map-custom.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('assets/js/chart-custom.js') }}"></script>
    <script src="{{ asset('assets/js/charts/01.js') }}"></script>
    <script src="{{ asset('assets/js/charts/02.js') }}"></script>

    <!-- slider JavaScript -->
    <script src="{{ asset('assets/js/slider.js') }}"></script>

    <!-- Emoji picker -->
    <script src="{{ asset('assets/vendor/emoji-picker-element/index.js') }}" type="module"></script>

    <!-- app JavaScript -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        // Function to show Bootstrap alerts dynamically
        function showDatumAlert(type, message) {
            $('#alert-container').html('');
            const alertHtml = `
                <div class="alert text-white bg-${type}" role="alert">
                    <div class="iq-alert-icon">
                        <i class="ri-${type === 'success' ? 'alert-line' : 'information-line'}"></i>
                    </div>
                    <div class="iq-alert-text">${message}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
            `;
            // Append alert to a container (use Datum's alert container or your own)
            $('#alert-container').html(alertHtml);
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
    @yield('APP-SCRIPT')
</body>

</html>
