<!doctype html>
<html lang="en" style="direction: rtl;">

<head>

{{-- start incloude css --}}
    @include('admin.layouts.assets.css')
{{-- end incloude css --}}

</head>

<body data-sidebar="dark">

<!-- <body data-layout="horizontal" data-topbar="dark"> -->

<!-- Begin page -->
<div id="layout-wrapper">



{{-- start incloude sidebar --}}
@include('admin.layouts.inc.sidebar')
{{-- end incloude sidebar --}}


{{-- start incloude header --}}
    @include('admin.layouts.inc.header')
{{-- end incloude header --}}

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">@yield('title')</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    @yield('links')
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        {{-- start incloude footer --}}
        @include('admin.layouts.inc.footer')
        {{-- end incloude footer --}}
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

{{-- start incloude js --}}
@include('admin.layouts.assets.js')
{{-- end incloude js --}}

</body>

</html>
