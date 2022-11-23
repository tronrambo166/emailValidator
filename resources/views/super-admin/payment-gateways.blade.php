@extends('layouts.super-admin-portal')
@section('content')
    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('Name')}}</th>

                    <th></th>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <td>
                        <div class="d-flex px-2">
                            <div>

                                <svg xmlns="http://www.w3.org/2000/svg" height="80" width="120" xml:space="preserve"
                                     y="0" x="0" id="Layer_1" version="1.1" viewBox="-54 -37.45 468 224.7"><style
                                        id="style16" type="text/css">.st0 {
                                            fill-rule: evenodd;
                                            clip-rule: evenodd;
                                            fill: #32325d
                                        }</style>
                                    <g transform="translate(-54 -36)" id="g32">
                                        <path id="path18"
                                              d="M414 113.4c0-25.6-12.4-45.8-36.1-45.8-23.8 0-38.2 20.2-38.2 45.6 0 30.1 17 45.3 41.4 45.3 11.9 0 20.9-2.7 27.7-6.5v-20c-6.8 3.4-14.6 5.5-24.5 5.5-9.7 0-18.3-3.4-19.4-15.2h48.9c0-1.3.2-6.5.2-8.9zm-49.4-9.5c0-11.3 6.9-16 13.2-16 6.1 0 12.6 4.7 12.6 16z"
                                              class="st0"/>
                                        <path id="path20"
                                              d="M301.1 67.6c-9.8 0-16.1 4.6-19.6 7.8l-1.3-6.2h-22v116.6l25-5.3.1-28.3c3.6 2.6 8.9 6.3 17.7 6.3 17.9 0 34.2-14.4 34.2-46.1-.1-29-16.6-44.8-34.1-44.8zm-6 68.9c-5.9 0-9.4-2.1-11.8-4.7l-.1-37.1c2.6-2.9 6.2-4.9 11.9-4.9 9.1 0 15.4 10.2 15.4 23.3 0 13.4-6.2 23.4-15.4 23.4z"
                                              class="st0"/>
                                        <path id="polygon22" class="st0" d="M248.9 36l-25.1 5.3v20.4l25.1-5.4z"/>
                                        <path id="rect24" class="st0" d="M223.8 69.3h25.1v87.5h-25.1z"/>
                                        <path id="path26"
                                              d="M196.9 76.7l-1.6-7.4h-21.6v87.5h25V97.5c5.9-7.7 15.9-6.3 19-5.2v-23c-3.2-1.2-14.9-3.4-20.8 7.4z"
                                              class="st0"/>
                                        <path id="path28"
                                              d="M146.9 47.6l-24.4 5.2-.1 80.1c0 14.8 11.1 25.7 25.9 25.7 8.2 0 14.2-1.5 17.5-3.3V135c-3.2 1.3-19 5.9-19-8.9V90.6h19V69.3h-19z"
                                              class="st0"/>
                                        <path id="path30"
                                              d="M79.3 94.7c0-3.9 3.2-5.4 8.5-5.4 7.6 0 17.2 2.3 24.8 6.4V72.2c-8.3-3.3-16.5-4.6-24.8-4.6C67.5 67.6 54 78.2 54 95.9c0 27.6 38 23.2 38 35.1 0 4.6-4 6.1-9.6 6.1-8.3 0-18.9-3.4-27.3-8v23.8c9.3 4 18.7 5.7 27.3 5.7 20.8 0 35.1-10.3 35.1-28.2-.1-29.8-38.2-24.5-38.2-35.7z"
                                              class="st0"/>
                                    </g></svg>
                            </div>

                        </div>
                    </td>
                    <td>
                    <span class="badge badge-dot me-4">
                    <i class="bg-info"></i>
                    </span>
                    </td>
                    <td class="float-end">

                        <a href="./configure-payment-gateway?api_name=stripe" type="button" class="btn btn-info btn-md">
                            @if(!empty($payment_gateways['stripe']->public_key))
                                {{__('Edit')}}
                            @else
                                {{__('Configure')}}
                            @endif
                        </a>

                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
