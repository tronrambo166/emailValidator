@extends('layouts.primary')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="font-weight-bolder">{{__('Business Model Canvas')}}</h4>
                    <p><strong>{{__('Source: Harvard Business Review, Entreprenuers Handbook ')}}</strong></p>
                    <hr>
                    <form method="post" action="{{route('/business-model-post')}}">
                        @if ($errors->any())
                            <div class="alert bg-pink-light text-danger">
                                <ul class="list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">
                                {{__('Business/Company Name')}}
                            </label><label class="text-danger">*</label>
                            <input class="form-control" name="company_name" id="company_name"
                                   @if (!empty($model))
                                   value="{{$model->company_name}}"
                                @endif
                            >
                        </div>
                        <div class="row mt-4">
                            <div class="col align-self-center">
                                <div class="form-group">

                                    <label for="exampleFormControlTextarea1">
                                        {{__('Key Partners')}}
                                    </label>
                                    <p class="form-text text-muted text-xs ms-1">
                                        {{__('Who are our key partners?')}}

                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">

                                        {{__('Who are our key Suppliers?')}}

                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">

                                        {{__('Which key resources are we acquiring from our partners?')}}

                                    </p>

                                    <textarea class="form-control mt-4" rows="10" id="partners"
                                              name="partners">@if (!empty($model)){{$model->partners}}@endif</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col align-self-end">
                                <div class="col align-self-center">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">
                                            {{__('Key Activities')}}
                                        </label>
                                        <p class="form-text text-muted text-xs ms-1">
                                            {{__('What key activities do our value propositions require?')}}
                                        </p>
                                        <textarea class="form-control mt-4" rows="10" id="activities"
                                                  name="activities">@if (!empty($model)){{$model->activities}}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col align-self-center">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">
                                        {{__('Key Resources')}}
                                    </label>
                                    <p class="form-text text-muted text-xs ms-1">
                                        {{__('What key resources do our value propositions reequire?')}}
                                    </p>
                                    <textarea class="form-control mt-4" rows="10" id="resources"
                                              name="resources">@if (!empty($model)){{$model->resources}}@endif</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col align-self-center">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">
                                        {{__('Value Propositions')}}
                                    </label>
                                    <p class="form-text text-muted text-xs ms-1">
                                        {{__(' What value do we deliver to the customer ?')}}
                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        {{__('Which one of our customers problem are we helping to solve?')}}
                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        {{__('What bundle of products or services are we offering to each segment?')}}
                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        {{__('Which customer needs are we satisfying?')}}
                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        {{__('What is the minimum viable product?')}}
                                    </p>

                                    <textarea class="form-control" rows="10" id="value_propositions"
                                              name="value_propositions">
@if (!empty($model)){{$model->value_propositions}}@endif</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col align-self-end">
                                <div class="col align-self-center">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">
                                            {{__('Customer Relationships')}}
                                        </label>
                                        <p class="form-text text-muted text-xs ms-1">
                                            {{__(' How do we get, keep and grow customers?')}}
                                        </p>
                                        <p class="form-text text-muted text-xs ms-1">
                                            {{__(' Which cuustommer relationships have we established ?')}}
                                        </p>
                                        <p class="form-text text-muted text-xs ms-1">
                                            {{__(' How are they integrated with the rest of our business model?')}}
                                        </p>
                                        <p class="form-text text-muted text-xs ms-1">
                                            {{__('How costly are they?')}}

                                        </p>

                                        <textarea class="form-control mt-4" rows="10" id="customer_relationships" name="customer_relationships">@if(!empty($model)){{$model->customer_relationships}}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col align-self-center">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">
                                        {{__('Channels')}}
                                    </label>
                                    <p class="form-text text-muted text-xs ms-1">
                                        {{__('  Through which channels do our customer segments wants to be reached?')}}
                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        {{__('How do other companies reach them now?')}}
                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        {{__('Which ones work best?')}}
                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        {{__('Which ones are most cost-efficient?')}}
                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        {{__('How are we integrating them with customer routines?')}}
                                    </p>
                                    <textarea class="form-control mt-4" rows="10" id="channels" name="channels">@if(!empty($model)){{$model->channels}}@endif</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col align-self-center">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">
                                        {{__('Customer Segments')}}
                                    </label>
                                    <p class="form-text text-muted text-xs ms-1">
                                        {{__('For whom are we creating value?')}}

                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        {{__('Who are our most important customers?')}}

                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        {{__('What are the customer archetypes?')}}

                                    </p>
                                    <textarea class="form-control" rows="10" id="customer_segments" name="customer_segments">
@if(!empty($model)){{$model->customer_segments}}@endif</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col align-self-end">
                                <div class="col align-self-center">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">
                                            {{__('Cost Structure')}}
                                        </label>
                                        <p class="form-text text-muted text-xs ms-1">
                                            {{__('What are the most immportant costs inherent to our business model?')}}
                                        </p>
                                        <p class="form-text text-muted text-xs ms-1">
                                            {{__('Which key resources are most expensive?')}}

                                        </p>
                                        <p class="form-text text-muted text-xs ms-1">
                                            {{__('Which key activities are most expensive?')}}

                                        </p>


                                        <textarea class="form-control" rows="10" id="cost_structure"
                                                  name="cost_structure">
@if(!empty($model)){{$model->cost_structure}}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col align-self-center">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">
                                        {{__('Revenue Stream')}}
                                    </label>
                                    <p class="form-text text-muted text-xs ms-1">
                                        {{__('For what value are our customers willing to pay?')}}
                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        {{__('For what do they currently pay?')}}
                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        {{__('What is the revenue model?')}}
                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        {{__('What are the pricing tactics?')}}
                                    </p>
                                    <textarea class="form-control" rows="10" id="revenue_stream" name="revenue_stream">@if(!empty($model)){{$model->revenue_stream}}@endif</textarea>
                                </div>
                            </div>
                        </div>
                        @if($model)
                            <input type="hidden" name="id" value="{{$model->id}}">
                        @endif
                        @csrf
                       <button class="btn btn-info mt-4" type="submit">{{__('Save')}}</button>
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
            flatpickr("#date", {

                dateFormat: "Y-m-d",
            });

        });

    </script>
    <script>

        (function(){
            "use strict";

            tinymce.init({
                selector: '#partners',

                plugins: 'lists,table',
                toolbar: 'numlist bullist',
                lists_indent_on_tab: false
            });
            tinymce.init({
                selector: '#activities',

                plugins: 'lists,table',
                toolbar: 'numlist bullist',
                lists_indent_on_tab: false
            });
            tinymce.init({
                selector: '#resources',

                plugins: 'lists,table',
                toolbar: 'numlist bullist',
                lists_indent_on_tab: false
            });
            tinymce.init({
                selector: '#customer_relationships',

                plugins: 'lists,table',
                toolbar: 'numlist bullist',
                lists_indent_on_tab: false
            });
            tinymce.init({
                selector: '#cost_structure',

                plugins: 'lists,table',
                toolbar: 'numlist bullist',
                lists_indent_on_tab: false
            });
            tinymce.init({
                selector: '#customer_segments',

                plugins: 'lists,table',
                toolbar: 'numlist bullist',
                lists_indent_on_tab: false
            });
            tinymce.init({
                selector: '#channels',

                plugins: 'lists,table',
                toolbar: 'numlist bullist',
                lists_indent_on_tab: false
            });
            tinymce.init({
                selector: '#value_propositions',

                plugins: 'lists,table',
                toolbar: 'numlist bullist',
                lists_indent_on_tab: false
            });
            tinymce.init({
                selector: '#revenue_stream',

                plugins: 'lists,table',
                toolbar: 'numlist bullist',
                lists_indent_on_tab: false
            });
        })();
    </script>

@endsection
