@extends('layouts.primary')
@section('content')
    <div class=" row">
        <div class="col">
            <h5 class="text-secondary fw-bolder">
                {{__('Business Models')}}
            </h5>
        </div>
        <div class="col text-end">
            <a href="./design-business-model" type="button" class="btn btn-info ">{{__('Design Business Model')}}</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="row">
                @foreach($models as $model)
                    <div class="col-lg-4 col-md-6 col-12 mt-lg-0 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row ">
                                    <div class="col-md-9">
                                        <h5 class="text-dark fw-bolder">{{$model->company_name}}</h5>
                                        <h6 class="text-secondary text-sm">{{$model->updated_at->format(config('app.date_format'))}}</h6>
                                    </div>
                                    <div class="col-3 text-end">
                                        <div class="dropstart">
                                            <a href="javascript:" class="text-secondary" id="dropdownMarketingCard"
                                               data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-lg-start px-2 py-3"
                                                aria-labelledby="dropdownMarketingCard">
                                                <li><a class="dropdown-item border-radius-md"
                                                       href="./design-business-model?id={{$model->id}}">{{__('Edit')}}</a>
                                                </li>
                                                <li><a class="dropdown-item border-radius-md"
                                                       href="./view-business-model?id={{$model->id}}">{{__('See Details')}}</a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item border-radius-md text-danger"
                                                       href="./delete/business-model/{{$model->id}}">{{__('Delete')}}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
