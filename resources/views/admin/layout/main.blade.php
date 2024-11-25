<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Point Of Sale | Dashboard 2</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Font: Source Sans Pro -->
    @include('admin.includes.header_script')
    @yield('css')
    @yield('style')
</head>
{{--<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">--}}
<body class="hold-transition  sidebar-mini layout-fixed" data-base-url="{{ asset('') }}">
{{--<script>--}}
{{--    $(document).read(function(){--}}
{{--        $.ajaxSetup({--}}
{{--            headers: {--}}
{{--                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--            }--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
<div class="wrapper">
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="{{asset('backend') }}/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

         @include('admin.includes.navbar')
         @include('admin.includes.sidebar')

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
               @yield("header_top")
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                @yield("content")
            </div>
        </section>
    </div>
</div>

<!-- ./wrapper -->

@include('admin.includes.footer')


