<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf_token" content="{{ csrf_token() }}" />
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <title>{{ __('common.app_name') }}</title>
        <!--favicon-->
        <link rel="icon" href="{{ asset('assets/images/icon-app.png') }}" type="image/png" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        @vite([
            'resources/css/metisMenu.min.css',
            'resources/css/bootstrap.min.css',
            'resources/css/icons.css',
            'resources/css/syndash.css',
            'resources/css/app.css', 
            'resources/css/select2-bootstrap4.css',
            'resources/css/select2.min.css',
            'resources/css/custom.css',
        ])
        @livewireStyles
    </head>
    <body>
        <!-- wrapper -->
        <div class="wrapper">
            <!--sidebar-wrapper-->
            @livewire('sidebar')
            <!--header-->
            @livewire('header')
            <!--main-->
            <div class="page-wrapper">
                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="row">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
            <!--start overlay-->
            <div class="overlay toggle-btn-mobile"></div>
            <!--end overlay-->
            <!--Start Back To Top Button--> 
            <a href="javaScript:;" class="back-to-top">
                <i class='bx bxs-up-arrow-alt'></i>
            </a>
            <!--End Back To Top Button-->
        </div>
        <!-- end wrapper -->
        @vite([
            'resources/js/app.js',
            'resources/js/syndash.js',
            'resources/js/main.js',
            'resources/js/import.js'
            ])
        @stack('modals')
        @if(Session::has('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    showAlertSuccess("{{ Session::get('success') }}");
                });
            </script>
        @endif
        @if(Session::has('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    showAlertError("{{ Session::get('error') }}");
                });
            </script>
        @endif
        @if (get_settings('sidebar_style'))
            <script type="module">
                $(document).ready(function() {
                    var sidebar_style = "{{ get_settings('sidebar_style') }}"; 

                    if (sidebar_style === 'full') {
                        $('#menu').find('ul').addClass('mm-show');
                    } else if (sidebar_style === 'dropdown') {
                        $('#menu').removeClass('mm-show'); 
                    }

                    var sidebar_setting = "{{ get_settings('sidebar') }}";
                });
            </script>
        @endif
        @livewireScripts
        @stack('js')
    </body>
</html>
