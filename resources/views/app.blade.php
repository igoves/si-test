<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div  class="container">
        <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/uploads/PHP_Full_Stack.doc" target="_blank">technical task</a>
            </li>
        </ul>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav flex-row ml-md-auto  d-md-flex">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" oninput="siModule.searchInput(this)" aria-label="Search">
                <button type="button" class="btn btn-outline-primary ml-1" onclick="siModule.addUser()">New User</button>
            </div>
        </div>
    </div>
</nav>
<div class="modal fade" id="UserModal" tabindex="-1" role="dialog" aria-labelledby="UserModalLabel" aria-hidden="true"></div>
<section class="container" id="root">
    @include('partials.list')
</section>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/jquery.form.js') }}"></script>
<script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>
<script>
var siModule = (function() {
    let _init, _um;
    _init = function() {
        $('#ajaxForm').ajaxForm({
            success: function(res) {
                if ( res.status === 0 ) {
                    $.notify({
                        title: "Sorry:",
                        message: res.msg
                    }, {type: 'danger', delay: 3000, z_index:9999});
                    return false;
                } else {
                    $.get("list", function(data) {
                        $('#root').html(data);
                    });
                    _um.modal('hide');
                    $.notify({
                        title: "Success:",
                        message: res.msg
                    }, {type: 'success', delay: 3000,});
                }
            }
        });
        if ( parseInt($('select[name=time_management]').val()) === 10 ) {
            $('#Project').attr("multiple", 'multiple');
        } else {
            $('#Project').attr("multiple", false);
        }
    };
    _um = $('#UserModal');
    return {
        searchInput: function (data) {
            $.post('search', {text: $(data).val(), _token: Laravel.csrfToken}, function(res) {
                $('#root').html(res);
            });
        },
        addUser: function () {
            $.get("add", function(data) {
                _um.html(data);
                _um.modal('show');
                _init();
            });
        },
        userEdit: function (user_id) {
            $.get("edit", {user_id: user_id}, function(data) {
                _um.html(data);
                _um.modal('show');
                _init();
            });
        },
        removePhoto: function (user_id) {
            $.post("remove_photo", {user_id: user_id, _token: Laravel.csrfToken}, function(res) {
                if ( res.status === 0 ) {
                    $.notify({
                        title: "Sorry:",
                        message: res.msg
                    }, {type: 'danger', delay: 3000, z_index:9999});
                    return false;
                } else {
                    $.notify({
                        title: "Success:",
                        message: res.msg
                    }, {type: 'success', delay: 3000, z_index:9999});
                }
                $('input[name=photo]').remove();
                $('#photo_block').empty().html('<input type="file" name="photo" class="form-control-file" id="Photo" placeholder="Photo" value="">');
            });
        },
        timeManagement: function (data) {
            if ( parseInt($(data).val()) === 10 ) {
                $('#Project').attr("multiple", 'multiple');
            } else {
                $('#Project').attr("multiple", false);
            }
        },
    }
}());
</script>
</body>
</html>
