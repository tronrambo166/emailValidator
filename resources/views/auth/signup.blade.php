<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        {{config('app.name')}}
    </title>
    <link id="pagestyle" href="css/app.css" rel="stylesheet"/>
</head>
<body class="g-sidenav-show  bg-gray-100">
<section class="min-vh-100">
    <div class="row">
        <div class="col-md-7">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="text-center mx-auto">
                        <h1 class=" text-purple mb-4 mt-10">{{__('“Play by the rules, but be ferocious.” ')}}</h1>
                        <h6 class="text-lead text-success">{{__('– Phil Knight')}}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="container">
                <div class=" card z-index-0 mt-5">
                    <div class="card-header text-start pt-4">
                        <h4>{{__('SignUp')}}</h4>
                    </div>
                    <div class="card-body">
                        <form role="form text-left" method="post" action="{{route('/signup')}}">
                            @if (session()->has('status'))
                                <div class="alert alert-success">
                                    {{session('status')}}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="list-unstyled">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <label>{{__('First Name')}}</label>
                            <div class="mb-3">
                                <input name="first_name" class="form-control" type="text" placeholder="First name"
                                       aria-describedby="email-addon">
                            </div>
                            <label>{{__('Last Name')}}</label>
                            <div class="mb-3">
                                <input type="text" name="last_name" class="form-control" placeholder="Last name"
                                       aria-describedby="email-addon">
                            </div>
                            <label>{{__('Email')}}</label>
                            <div class="mb-3">
                                <input type="email" placeholder="Email" name="email" class="form-control"
                                       aria-label="Email" aria-describedby="email-addon">
                            </div>
                            <label>{{__('Choose Password')}}</label>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                       aria-label="Password" aria-describedby="password-addon">
                            </div>
                            @csrf
                            <div class="text-start">
                                <button type="submit" class="btn btn-info  my-4 mb-2">{{__('Sign up')}}</button>
                            </div>
                            <p class="text-sm mt-3 mb-0">{{__('Already have an account?')}} <a href="./login"
                                                                                               class="text-dark font-weight-bolder">{{__('Sign in')}}</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

    (function(){
        "use strict";
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    })();
</script>

</body>

</html>
