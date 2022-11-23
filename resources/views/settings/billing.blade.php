@extends('layouts.primary')
@section('content')


    @if($workspace->subscribed)

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h6 class="fw-bolder">{{__('Billing')}}</h6>
                         @if(Session::has('plan_name'))
                            <p>You are subscribed to the <b class="text-success">{{Session::get('plan_name')}}</b></p>
                        @endif 
                        @if(!empty($workspace->next_renewal_date))
                            <p><strong>{{__('Next renewal date')}}:</strong> {{date('M d Y',strtotime($workspace->next_renewal_date))}}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @else
        <div class="row">
            <div class="col-md-7 mx-auto text-center">
                <span class="badge bg-purple-light mb-3">{{__('Pricing and Plans')}}</span>
                <h3 class="text-dark">{{__('Ready to get started with StartupKit?Awesome!')}}</h3>
                <p class="text-secondary">{{__('Choose the plan that best fit for you.')}}</p>
            </div>
        </div>
        <div class="row mt-4">
            @foreach($plans as $plan)
                <div class="col-md-3  mb-4 ">
                    <div class="card ">
                        
                        <div class="card-body mx-auto pt-0">
                            @if($plan->features)

                                @foreach(json_decode($plan->features) as $feature)

                                    <div class="justify-content-start d-flex px-2 py-1">
                                        <div>
                                            <i class="icon icon-shape text-center icon-xs rounded-circle fas fa-check bg-purple-light text-purple text-sm"></i>
                                        </div>
                                        <div class="ps-2">
                                            <span class="text-sm">{{$feature}}</span>
                                        </div>
                                    </div>


                                @endforeach
                            @endif
                        </div>
                        <div class="card-footer pt-0">
                            @if($plan->price_monthly)

                                <a href="./subscribe?id={{$plan->id}}&term=monthly" type="button"
                                   class="btn btn-info ">{{__('Pay Monthly')}}</a>

                            @endif
                            @if($plan->price_yearly)

                                <a href="./subscribe?id={{$plan->id}}&term=yearly" type="button"
                                   class="btn btn-success ">{{__('Pay Yearly')}}</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @endif


@endsection

