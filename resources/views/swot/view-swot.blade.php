@extends('layouts.primary')
@section('content')
    <div class=" row">
        <div class="col">
            <h5 class="mb-2 text-secondary fw-bolder">
                {{__('SWOT Analysis of')}} {{$model->company_name}}
            </h5>
        </div>
        <div class="col text-end">
            <a href="/swot-list" type="button" class="btn btn-info">
                {{__('List SWOT Analysis')}}
            </a>
        </div>
    </div>
    <div class="card-group">
        <div class="card">
            <div class="card-header text-purple bg-purple-light border-success">{{__('Strengths')}}</div>
            <div class="card-body">
                <p> {!!clean($model->strengths)!!}</p>
            </div>
        </div>
        <div class="card">
            <div class="card-header text-danger bg-pink-light border-success">{{__('Weaknesses')}}</div>
            <div class="card-body">
                <p class="card-text">{!!clean($model->weaknesses)!!}</p>
            </div>
        </div>
        <div class="card">
            <div class="card-header fw-bolder  text-success bg-success-light border-success">{{__('Opportunities')}}
            </div>
            <div class="card-body">
                <p class="card-text">{!!clean($model->opportunities)!!}</p>
            </div>
        </div>
        <div class="card">
            <div class="card-header fw-bolder text-warning bg-warning-light border-success">{{__('Threats')}}</div>
            <div class="card-body">
                <p class="card-text">{!!clean($model->threats)!!}</p>
            </div>
        </div>
    </div>
@endsection
