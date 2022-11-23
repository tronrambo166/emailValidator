@extends('layouts.super-admin-portal')
@section('content')

    <div class="card">
        <div class="card-header">
            {{__('Configure payment gateway')}}
        </div>

        <div class="card-body pt-0">

            <form action="{{route('/configure-gateway')}}" method="post">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @switch($api_name)

                    @case('paypal')

                    <h5 class="mb-3">{{__('PayPal')}}</h5>

                    <div class="form-group">
                        <label for="Paypal Email/Paypal Client ID">{{__('Paypal Email/Paypal Client ID')}}</label>
                        <input type="email" name="username" class="form-control" id="exampleFormControlInput1">
                    </div>

                    @break


                    @case('stripe')

                    <h5 class="mb-3">{{__('Stripe')}}</h5>

                    <div class="form-group">
                        <label for="Public Key">{{__('Public Key')}}</label>
                        <input type="text" name="public_key" @if (!empty($gateway)) value="{{$gateway->public_key}}"@endif class="form-control" id="public_key">
                    </div>

                    <div class="form-group">
                        <label for="Private Key">{{__('Private Key')}}</label>
                        <input type="text" name="private_key" @if (!empty($gateway)) value="{{$gateway->private_key}}"@endif class="form-control" id="private-key">
                    </div>

                    @break


                @endswitch



                @csrf

                @if($gateway)
                    <input type="hidden" name="id" value="{{$gateway->id}}">
                @endif


                <button type="submit" class="btn btn-success">{{__('Save')}}</button>


            </form>

        </div>





    </div>



@endsection


