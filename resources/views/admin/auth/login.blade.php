<!doctype html>
<html lang="en">

<head>
    <title>تسجيل الدخول</title>


    {{-- start incloude css --}}
    @include('admin.layouts.assets.css')
    {{-- end incloude css --}}

</head>

<body>
<div class="account-pages my-5 pt-sm-5" dir="rtl">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div class="bg-primary bg-soft">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-4">
                                    <h5 class="text-primary">مرحباً بعودتك</h5>
                                    <p>قم بتسجيل الدخول</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{get_file('assets/admin/images/profile-img.png')}}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="auth-logo">
                            <a href="#!" class="auth-logo-light">
                                <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{get_file(setting()->logo)}}" alt="" class="rounded-circle" height="34">
                                            </span>
                                </div>
                            </a>

                            <a href="#!" class="auth-logo-dark">
                                <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{get_file(setting()->logo)}}" alt="" class="rounded-circle" height="34">
                                            </span>
                                </div>
                            </a>
                        </div>
                        <div class="p-2">
                            <form class="form-horizontal" action="{{route('admin.login')}}" id="LoginForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">البريد الإلكترونى</label>
                                    <input type="email" style="direction: rtl !important;" class="form-control" id="email" name="email" placeholder="Enter email">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">كلمة المرور</label>
                                    <div class="input-group auth-pass-inputgroup">
                                        <input type="password" class="form-control" placeholder="Enter password" name="password" aria-label="Password" aria-describedby="password-addon">
                                        <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                    </div>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-check">
                                    <label class="form-check-label" for="remember-check">
                                        Remember me
                                    </label>
                                </div>

                                <div class="mt-3 d-grid">
                                    <button class="btn btn-primary waves-effect waves-light" id="loginButton" type="submit">تسجيل</button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
                <div class="mt-5 text-center">

                    <div>
                        <p>© <script>document.write(new Date().getFullYear())</script> {{setting()->title}}. Crafted with <i class="mdi mdi-heart text-danger"></i> by Motaweron</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- end account-pages -->


{{-- start incloude js --}}
@include('admin.layouts.assets.js')
{{-- end incloude js --}}
<script>
    $("form#LoginForm").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var url = $('#LoginForm').attr('action');
        $.ajax({
            url:url,
            type: 'POST',
            data: formData,
            beforeSend: function(){
                $('#loginButton').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                    ' ></span> <span style="margin-left: 4px;">جاري تسجيل الدخول</span>').attr('disabled', true);

            },
            complete: function(){


            },
            success: function (data) {
                if (data == 200){
                    toastr.success('تم تسجيل الدخول بنجاح');
                    window.setTimeout(function() {
                        window.location.href="{{route('admin.index')}}";
                    }, 1000);
                }else {
                    toastr.error('خطأ فى كلمة المرور');
                    $('#loginButton').html(`<i id="lockId" class="fa fa-lock" style="margin-left: 6px"></i> دخول`).attr('disabled', false);
                }

            },
            error: function (data) {
                if (data.status === 500) {
                    $('#loginButton').html(`<i id="lockId" class="fa fa-lock" style="margin-left: 6px"></i> دخول`).attr('disabled', false);
                    toastr.error('هناك خطأ ما');
                }
                else if (data.status === 422) {
                    $('#loginButton').html(`<i id="lockId" class="fa fa-lock" style="margin-left: 6px"></i> دخول`).attr('disabled', false);
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function (key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function (key, value) {
                                toastr.error(value,key);
                            });

                        } else {
                        }
                    });
                }else {
                    $('#loginButton').html(`<i id="lockId" class="fa fa-lock" style="margin-left: 6px"></i> Login`).attr('disabled', false);

                    toastr.error('there in an error');
                }
            },//end error method

            cache: false,
            contentType: false,
            processData: false
        });
    });

</script>

</body>
</html>
