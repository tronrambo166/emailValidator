@extends('layouts.super-admin-portal')
@section('content')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-9 col-12 mx-auto">
                <div class="card card-body">
                     @if (!empty($plan))
                    <h6 class="mb-0">{{__('Edit Plan')}}</h6>
                    </p>
                    @else
                    <h6 class="mb-0">{{__('New Plan')}}</h6>
                    <p class="text-sm mb-0">{{__('Create new plan')}}
                    </p>
                    @endif
                    <form action="{{route('/save-subscription-plan')}}" method="post">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <hr class="horizontal dark my-3">
                        <label for="projectName" class="form-label">{{__('Plan Name')}}</label>
                        <input type="text" class="form-control" name="name" @if (!empty($plan)) value="{{$plan->name}}"
                               @endif id="projectName">
                            <label for="projectName" class="form-label mt-3">{{__('Maximum Allowed Users')}}</label>
                            <input type="number" class="form-control" name="maximum_allowed_users" @if (!empty($plan)) value="{{$plan->maximum_allowed_users}}"
                                   @endif id="projectName">
                        <div class="row mt-4">
                            <label>
                                {{__('Pricing')}}
                            </label>
                            <div class="col-6">
                                <label class="form-label">{{__('Monthly')}}</label>
                                <input class="form-control datetimepicker" type="text" name="price_monthly"
                                       @if (!empty($plan)) value="{{$plan->price_monthly}}" @endif data-input>
                            </div>
                            <div class="col-6">
                                <label class="form-label">{{__('Yearly')}}</label>
                                <input class="form-control datetimepicker" name="price_yearly" type="text"
                                       @if (!empty($plan)) value="{{$plan->price_yearly}}" @endif data-input>
                            </div>
                        </div>
                        <label
                            class="text-uppercase text-body text-xs font-weight-bolder mt-4">{{__('Modules')}}</label>
                        <ul class="list-group">
                            @foreach($available_modules as $key => $value)
                                <li class="list-group-item border-0 px-0">
                                    <div class="form-check form-switch ps-0">
                                        <input class="form-check-input ms-auto" type="checkbox" id="module_{{$key}}"
                                               name="{{$key}}" value="1"
                                               @if(!empty($plan_modules) && in_array($key,$plan_modules)) checked @endif>
                                        <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                               for="module_{{$key}}">{{$value}}</label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <label class="mt-4">{{__('Description')}}</label>

                        <div class="form-group">
                            <textarea class="form-control" rows="10" id="description"
                                      name="description">@if(!empty($plan)){{$plan->description}}@endif</textarea>
                        </div>

                       <!-- <div class="mb-3">
                            <label class="form-label">{{__('Features')}}</label>
                            <div id="div_features">

                                @if(!empty($features))
                                    @foreach($features as $feature)
                                        <div class="row feature_row">
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="features[]" value="{!! $feature !!}">
                                            </div>
                                            <div class="col-md-3 text-end">
                                                <button class="btn btn-sm btn-danger btn_remove_feature"><i class="fas fa-minus"></i> </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="row feature_row">
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="features[]">
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <button class="btn btn-sm btn-danger btn_remove_feature"><i class="fas fa-minus"></i> </button>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div class="mb-3">
                            <button class="btn btn-sm btn-dark" id="btn_add_feature"><i class="fas fa-plus"></i>
                            </button>
                        </div> -->

                        @csrf
                        @if($plan)
                            <input type="hidden" name="id" value="{{$plan->id}}">
                        @endif
                        <div class="d-flex  mt-4">

                            <button type="submit" name="button"
                                    class="btn bg-gradient-primary m-0 ">{{__('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            "use strict";
            flatpickr("#start_date", {

                dateFormat: "Y-m-d",
            });

            flatpickr("#end_date", {

                dateFormat: "Y-m-d",
            });

            tinymce.init({
                selector: '#description',


                plugins: 'table,code',


            });

            let $btn_add_feature = $('#btn_add_feature');
            let $div_features = $('#div_features');

            $btn_add_feature.on('click', function (event) {
                event.preventDefault();
                $div_features.append('<div class="row feature_row"><div class="col-md-9"><input type="text" class="form-control" name="features[]"></div><div class="col-md-3 text-end"><button class="btn btn-sm btn-danger btn_remove_feature"><i class="fas fa-minus"></i> </button></div></div>');

            });

            let $clx_body = $('#clx_body');

            $clx_body.on('click', '.btn_remove_feature', function (event) {
                event.preventDefault();
                $(this).closest('.feature_row').remove();
            });
        });
    </script>
@endsection
