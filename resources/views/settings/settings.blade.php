@extends('layouts.'.($layout ?? 'primary'))
@section('content')
    <div class=" row">
        <div class="col">
            <h5 class=" text-secondary fw-bolder">
                {{__('Settings')}}
            </h5>
        </div>
        <div class="col text-end">
        </div>
    </div>
    <div class="row mb-5">
        <div class="  col-md-8 mt-lg-0 mt-4">
            <div class="card">
                <div class="card-body">
                    <form enctype="multipart/form-data" action="{{route('/settings')}}" method="post">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mt-4" id="basic-info">
                            <div class=" pt-0">
                                <div class="row">
                                    <label class="form-label">{{__('Workspace Name')}}</label>

                                    <div class="input-group">
                                        <input id="firstName" name="workspace_name" value="{{$workspace->name}}"
                                               class="form-control" type="text" required="required">
                                    </div>
                                </div>

                                @if ($user->super_admin)
                                    <div class="row">
                                        <div class="col-md-12 align-self-center">
                                            <div>
                                                <label for="logo_file" class="form-label mt-4">{{__('Upload Logo')}}</label>
                                                <input class="form-control" name="logo" type="file" id="logo_file">
                                            </div>
                                        </div>
                                    </div>

                                @endif
                                @if ($user->super_admin)
                                    <label class="form-label mt-3">{{__('Currency')}}</label>

                                    <div class="input-group">
                                        <input id="currency" name="currency" value="{{$settings['currency'] ?? config('app.currency')}}"
                                               class="form-control" type="text" required="required">
                                    </div>

                                @endif
                                @if ($user->super_admin)
                                    <div class="row">
                                        <div class="col-md-12 align-self-center">
                                            <div>
                                                <label for="free_trial_days" class="form-label mt-4">{{__('Free Trial Days')}}</label>
                                                <input class="form-control" name="free_trial_days" type="number" id="free_trial_days" value="{{$settings['free_trial_days'] ?? ''}}">
                                            </div>
                                        </div>
                                    </div>

                                @endif

                                @csrf
                                <button class="btn btn-info btn-sm float-left mt-4 mb-0">{{__('Update')}} </button>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </div>
@endsection
