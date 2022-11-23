@extends('layouts.primary')
@section('head')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
@endsection
@section('content')
    <h3>{{$plan->name}}</h3>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-unstyled">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

  <div class="col-sm-12">
         
         <div class="row w-75 m-auto py-3">

            <div class="col-md-9 col-md-offset-3">
                <h5 class="text-center">Pay with your Credit/Debit Card via Stripe    <i  class="fab fa-cc-mastercard fa-1x"></i> <i style="color:red" class="fab fa-cc-visa fa-1x"></i> </h5>
               <div class="panel m-auto panel-default credit-card-box">
                  <div class="panel-heading display-table" >
                     <div class="row display-tr" >
                        <div class="display-td" >                            
                           
                        </div>
                     </div>
                  </div>
                  <div class="panel-body">
                     @if (Session::has('success'))
                     <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                     </div>
                     @endif



                        <!-- Form Starts Here -->
                     <form     
                        role="form"
                        action="{{ route('stripe.post') }}"
                        method="post"
                        class="require-validation"
                        data-cc-on-file="false"
                        data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                        id="payment-form">
                        @csrf


                        <!-- Shipping address  starts -->

                         
      @php $name=Auth::user()->name; $email=Auth::user()->email; $currency=Auth::user()->currency; @endphp

                         
                        <div class='form-row row my-2'>
                           <div class='col-sm-12  form-group required'>
                              <label class='control-label'><b>  Amount </b></label> 
                              <input class='form-control' size='4' name="price" id="price" type='number' value="{{$amount}}" readonly >

                           </div> 

                        </div>  
                           <input type="hidden" name="plan_id" value="{{$plan->id}}">
                           <input type="hidden" name="term" value="{{$term}}">
                           <input hidden value="USD" type="text" name="currency"/>
                           
                                       
                                       

                        <!-- Shipping address  ends --> 




                        <div class='form-row row my-2'>
                           <div class='col-sm-12  form-group required'>
                              <label class='control-label'><b> Name on Card </b></label> <input
                                 class='form-control' size='4' type='text'>
                           </div>

                         <!--  <div class="col-sm-5 mt-4"><select  name="currency" id="currency" class="w-75 m-auto form-control" >
            
            <option hidden value="usd">Change currency</option>
            <option value="usd">(USD)</option>
            <option value="gbp">(GBP)</option>
            
            </select></div> -->


                        </div>
                        <div class='form-row row my-2'>
                           <div class='col-sm-12 form-group card required'>
                              <label class='control-label'><b> Card Number </b></label> <input
                                 autocomplete='off' class='form-control card-number' size='20'
                                 type='text'>

                                          

                           </div>

                         
                        </div>
                        <div class='form-row row my-2'>
                           <div class='col-xs-12 col-md-4 form-group cvc required'>
                              <label class='control-label'><b> CVC </b></label> <input autocomplete='off'
                                 class='form-control card-cvc' placeholder='ex. 311' size='4'
                                 type='text'>
                           </div>
                           <div class='col-xs-12 col-md-4 form-group expiration required'>
                              <label class='control-label'><b> Exp. Month </b></label> <input
                                 class='form-control card-expiry-month' placeholder='MM/Ex.  07' size='2'
                                 type='text'>
                           </div>
                           <div class='col-xs-12 col-md-4 form-group expiration required'>
                              <label class='control-label'><b> Exp. Year </b></label> <input
                                 class='form-control card-expiry-year' placeholder='YYYY/Ex. 2022' size='4'
                                 type='text'>
                           </div>
                        </div>
                        <div class='form-row row '>
                           <div class='col-md-12 error form-group  hide'>
                              <div class='alert-light alert text-danger'>
                              </div>
                           </div>
                        </div>


                        <div class="privacy-wrp mt-2 py-2">
                                            
                                                <input type="checkbox" required="" id="AND">
                                                <label for="AND" class="allterms d-inline"> 
                                                    <p class="d-inline small" style="font-size: 12px;">I HAVE READ AND AGREE TO THE WEBSITE <a href="#" disbaled> TERMS AND CONDITIONS</a></p>
                                                </label>  </div>


                        <div class="row">
                           <div class="col-sm-12 text-center">
                              <button id ="" class=" font-weight-bold btn btn-info m-auto btn-lg btn-block" type="submit" >Deposit <span id="paynow"></span><span id="stripBtn"></span></button>
                           </div>
                        </div>

                     </form>


                  </div>
               </div>
            </div>
         </div>
      </div>



@endsection

@section('script')
   <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
   <script type="text/javascript">
      $(function() {
    var $form = $(".require-validation");
    $('form.require-validation').bind('submit', function(e) {
        var $form = $(".require-validation"),
            inputSelector = ['input[type=email]', 'input[type=password]',
                'input[type=text]', 'input[type=file]',
                'textarea'
            ].join(', '),
            $inputs = $form.find('.required').find(inputSelector),
            $errorMessage = $form.find('div.error'),
            valid = true;
        $errorMessage.addClass('hide');
        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
            var $input = $(el);
            if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('hide');
                e.preventDefault();
            }
        });
        if (!$form.data('cc-on-file')) {
            e.preventDefault();
            Stripe.setPublishableKey($form.data('stripe-publishable-key'));
            Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
        }
    });
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
});
   </script>


@endsection
