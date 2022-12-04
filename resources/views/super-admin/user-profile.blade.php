@extends('layouts.super-admin-portal')
@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header pb-0 p-3">
                </div>
                <div class="card-body p-3">
                    <div class="row gx-4">
                        <div class="col-auto">
                            <div> @php $icon = explode(' ',$skit_user->name); @endphp
                                                @if(empty($skit_user['photo']))
                                                    <div
                                                        class="avatar avatar-md bg-success-light border-radius-md p-2 ">
                                                        <h6 class="text-success ">{{$icon['0']}}</h6>
                                                    </div>
                                                @else

                                                    <img src="{{PUBLIC_DIR}}/uploads/{{$skit_user->photo}}" alt=""
                                                         class="avatar avatar-md">
                                                @endif
                                            </div>
                        </div>
                        <div class="col-auto my-auto">
                            <div class="h-100">
                                <h5 class="mb-1">
                                    {{$skit_user->name}}

                                </h5>
                                <p class="mb-0 font-weight-bold text-sm">
                                    {{$skit_user->email}}
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                            <div class="nav-wrapper position-relative end-0">
                                <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 mb-4 ">
                        <div class="col-md-8 d-flex align-items-center">
                            <h6 class="mb-0 text-muted">{{__('Details')}}</h6>
                        </div>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong
                                class="text-dark">{{__('Full Name:')}}</strong> {{$skit_user->name}}
                        </li>
                        <li class="list-group-item border-0 ps-0 text-sm"><strong
                                class="text-dark">{{__('Mobile Number:')}}</strong> {{$skit_user->mobile_number}}</li>
                        <li class="list-group-item border-0 ps-0 text-sm"><strong
                                class="text-dark">{{__('Email:')}}</strong> {{$skit_user->email}}</li>
                        <li class="list-group-item border-0 ps-0 text-sm"><strong
                                class="text-dark">{{__('Account Created:')}}</strong> {{$skit_user->created_at}}</li>

                    </ul>

                    <a class="btn btn-info mb-3 mt-3" href="./user-edit-{{$skit_user->id}}">{{__('Edit')}}</a>

                </div>

            </div>
        </div>
      

    </div>
@endsection
