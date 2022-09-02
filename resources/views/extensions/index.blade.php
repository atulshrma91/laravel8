@extends('layouts.app')

@section('header-scripts')
<script src="{{ asset('https://js.stripe.com/v3/')}}" type="text/javascript"></script>
@endsection

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">extension</i>
            </div>
            <h4 class="card-title">Extensions</h4>
          </div>
          <div class="card-body">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-7">
                <small class="h3 text-info align-middle">Accounts</small>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
              </div>
              <div class="col-md-5">
                <a class="btn crm-btn-green btn-sm mt-4" href="{{url('extensions/accounts/settings')}}">Account settings</a>
              </div>
            </div>
          </div>
        </div>
        @if(!$extensions->isEmpty())
          @foreach($extensions as $extension)
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-7">
                  <div class="togglebutton">
                    <label>
                      <input type="checkbox" {{($extension->UserExtension->is_expired)?'disabled':''}} {{\Auth::user()->isExtensionActivated($extension->slug)?'checked':''}} data-id="{{$extension->id}}" class="enable-extension">
                      <span class="toggle"></span>
                      <small class="h3 text-info align-middle">{{$extension->name}}</small>
                    </label>
                  </div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                <div class="col-md-3">
                  <a class="btn crm-btn-green btn-sm mt-4 {{\Auth::user()->hasExtension($extension->slug) && \Auth::user()->isExtensionActivated($extension->slug)?'':'disabled'}}" href="{{\Auth::user()->hasExtension($extension->slug) && \Auth::user()->isExtensionActivated($extension->slug)?url('extensions/'.$extension->slug.'/settings'):'javascript:;'}}" role="button">{{$extension->name}} settings</a>
                </div>
                <div class="col-md-2">
                  <div class="mt-4">
                    @if(!$extension->UserExtension->is_expired)
                      @if($extension->UserExtension->on_trial)
                        @if($extension->UserExtension->trial_expiry_days)
                          @if(\Auth::user()->isExtensionActivated($extension->slug))
                            <h6 class="badge badge-info">Trial</h6>
                          @else
                            <h6 class="badge badge-secondary">Deactivated</h6>
                          @endif
                          <p><mark class="h4">{{$extension->UserExtension->trial_expiry_days}}</mark> days left</p>
                        @endif
                      @else
                        @if(date('Y-m-d') >= date('Y-m-d', strtotime($extension->UserExtension->extension_expiry)))
                          <h6 class="badge badge-danger">Expired</h6>
                        @else
                          @if(\Auth::user()->isExtensionActivated($extension->slug))
                            <h6 class="badge badge-success">Active</h6>
                          @else
                            <h6 class="badge badge-secondary">Deactivated</h6>
                          @endif
                          <p class="h4">${{$extension->price}}/<small>month</small></p>
                        @endif
                      @endif
                    @else
                      @if($extension->UserExtension->on_trial)
                        <h6 class="badge badge-danger">Trial has ended</h6>
                      @else
                        <h6 class="badge badge-danger">Expired</h6>
                      @endif

                      <!--div class="crm_paypal" title="Activate ${{$extension->price}}/month" rel="tooltip" data-placement="top">
                        <div class="extension_subscription_payment" data-extension_id="{{$extension->UserExtension->id}}"></div>
                        <div class="extension_paypal_error"></div>
                      </div-->
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        @endif
      </div>
      <div class="col-md-4">
        <form name="extensionCheckout">
          <div class="card">
            <div class="card-header card-header-info card-header-icon">
              <h4 class="card-title">Subscriptions</h4>
            </div>
            <div class="card-body">
              <div class="list-group">
                @if(!$extensions->isEmpty())
                  @foreach($extensions as $extension)
                    <div>
                      @if(!$extension->UserExtension->is_expired)
                        @if($extension->UserExtension->on_trial)
                          @if($extension->UserExtension->trial_expiry_days)
                            <small class="text-dark font-size-15">{{$extension->name}} <mark class="font-weight-bold h6 text-warning ml-3">Trial</mark></small>
                          @endif
                        @else
                          @if(date('Y-m-d') >= date('Y-m-d', strtotime($extension->UserExtension->extension_expiry)))
                          <div class="togglebutton">
                            <label>
                              <input type="checkbox" name="user_extension_id[]" value="{{$extension->UserExtension->id}}" class="user_extension">
                              <span class="toggle"></span>
                              <small class="text-dark font-size-15">{{$extension->name}} <mark class="font-weight-bold h6 text-danger ml-3"> Expired</mark></small>
                            </label>
                          </div>
                          @else
                            <small class="text-dark font-size-15">{{$extension->name}} <span class="font-weight-bold h6 text-success ml-3">${{$extension->price}}</span></small>
                          @endif
                        @endif
                      @else
                      <div class="togglebutton">
                        <label>
                          <input type="checkbox" name="user_extension_id[]" value="{{$extension->UserExtension->id}}" class="user_extension">
                          <span class="toggle"></span>
                          <small class="text-dark font-size-15">{{$extension->name}} <mark class="font-weight-bold h6 text-danger ml-3"> Expired</mark></small>
                        </label>
                      </div>
                      @endif
                    </div>
                  @endforeach
                @endif
            </div>
          </div>
        </div>
        @if($is_checkout_allowed)
          <div class="card">
            <div class="card-body">
                <div class="checkout-price mt-3">
                  <small class="text-dark font-size-15">Cart Total <span class="font-weight-bold h3 ml-3">$ 0</span></small>
                </div>
                @if($payment_methods)
                <div class="checkout-payment-methods mt-2">
                  <small class="text-dark font-size-15">Saved cards</small>
                  @foreach($payment_methods as $payment_method)
                    <div class="font-size-16">
                      <span class="ml-4">{{ucfirst($payment_method->card->brand)}} <small>ending **** </small> {{$payment_method->card->last4}} - <small>{{$payment_method->card->exp_month}}/{{$payment_method->card->exp_year}}</small></span>
                      <a class="btn btn-link btn-sm delete-payment-method" data-id="{{$payment_method->id}}"><i class="material-icons align-middle font-size-16" role="button">delete</i></a>
                    </div>
                  @endforeach
                </div>
                @endif
                @if(!$payment_methods)
                  <div id="card-element" class="mt-2"></div>
                @endif
                <button id="card-button" class="btn btn-warning btn-block active font-size-15" type="button"><span class="material-icons">shopping_cart</span>Checkout<span class="spinner-border ml-2 d-none"></span></button>
                <div id="card-errors" class="mt-1 text-danger"></div>
            </div>
          </div>
        @endif
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

    const swalWithMaterialButtons = Swal.mixin({
      confirmButtonClass: 'btn btn-success btn-sm',
      cancelButtonClass: 'btn btn-danger btn-sm',
      buttonsStyling: false,
    })
    jQuery(document).ready(function(){
      jQuery(document).on('change', '.enable-extension', function(e){
        e.preventDefault();
        let extension_id = jQuery(this).data('id')
        let status = 0;
        if(jQuery(this).is(":checked")){
          status = 1
        }
        jQuery.ajax({
            url: `{{url('extensions/access')}}`,
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify({extension_id: extension_id, status: status}),
            dataType: 'json',
            context: this,
            success: function (res) {
              if (res.success) {
                window.location.href = res.url
              }else{
                jQuery(this).prop('checked', false);
              }
            }
        });
      })

      jQuery(document).on('change', '.user_extension', function(e){
        e.preventDefault();
        jQuery('.checkout-price small span').html('')
        let userExtArr = []
        jQuery(".user_extension:checked").each(function(){
            userExtArr.push(jQuery(this).val());
        });
        jQuery.ajax({
            url: `{{url('extensions/get-checkout-price')}}`,
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify({user_extension: userExtArr}),
            dataType: 'json',
            context: this,
            success: function (res) {
              if (res.success) {
                jQuery('.checkout-price small span').html('$ '+res.checkout_price)
              }
            }
        });
      })



      if(jQuery('#card-element').length){
        var stripe = Stripe('{{env("STRIPE_PUBLISHABLE_KEY")}}');

        var elements = stripe.elements();
        var style = {
          base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
              color: '#aab7c4'
            }
          },
          invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
          }
        };
      	var cardElement = elements.create('card', {style: style});
      	cardElement.mount('#card-element');

        cardElement.addEventListener('change', function(event) {
          var displayError = document.getElementById('card-errors');
          if (event.error) {
            displayError.textContent = event.error.message;
          } else {
            displayError.textContent = '';
          }
        });

        jQuery(document).on('click', '#card-button', function(e){
          e.preventDefault();
          jQuery('#card-errors').html('')
          jQuery(this).find('.spinner-border').removeClass('d-none')
          let billing_details = {name: '{{auth()->user()->name}}', email: '{{auth()->user()->email}}'}
          let userExtArr = []
          jQuery(".user_extension:checked").each(function(){
              userExtArr.push(jQuery(this).val());
          });
          var formdata = [];
          stripe.createPaymentMethod('card', cardElement, {
		        billing_details: billing_details
		      }).then(function(result) {
		        if (result.error) {
							jQuery(this).find('.spinner-border').addClass('d-none')
							jQuery('#card-errors').html(result.error.message)
		        } else {
		          formdata.push({name: 'user_extension_id', value: userExtArr});
		          formdata.push({name: 'payment_method_id', value: result.paymentMethod.id});
              jQuery.ajax({
                  url: `{{url('extension/payment/subscription')}}`,
                  method: 'POST',
                  headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                  },
                  context: this,
                  data:formdata,
                  dataType:'json',
                  success: function (res) {
                    jQuery(this).find('.spinner-border').addClass('d-none')
                    if(res.success){
                      window.location.reload();
                    }else{
                      jQuery('#card-errors').html(res.message)
                    }
                  }
              });
		        }
		      });
        })
      }else{
        jQuery(document).on('click', '#card-button', function(e){
          e.preventDefault();
          jQuery('#card-errors').html('')
          jQuery(this).find('.spinner-border').removeClass('d-none')
          let userExtArr = []
          jQuery(".user_extension:checked").each(function(){
              userExtArr.push(jQuery(this).val());
          });
          var formdata = [];
          formdata.push({name: 'user_extension_id', value: userExtArr});
          jQuery.ajax({
              url: `{{url('extension/payment/subscription')}}`,
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
              context: this,
              data:formdata,
              dataType:'json',
              success: function (res) {
                jQuery(this).find('.spinner-border').addClass('d-none')
                if(res.success){
                  jQuery('#card-errors').html(res.message)
                  window.setTimeout(function(){location.reload()},2000)
                }else{
                  jQuery('#card-errors').html(res.message)
                }
              }
          });
        })
      }

      jQuery(document).on('click', '.delete-payment-method', function(){
        let id = jQuery(this).data('id')
        swalWithMaterialButtons({
          title: `{{__('account.alert_heading')}}`,
          text: `{!!__('account.alert_text')!!}`,
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: `{{__('account.alert_approve_btn')}}`,
          cancelButtonText: `{{__('account.alert_cancel_btn')}}`,
          showLoaderOnConfirm: true,
          preConfirm: (login) => {
            return fetch('/extensions/delete-payment-method', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({id: id})
              })
              .then(response => {
                if (!response.ok) {
                  throw new Error(response.statusText)
                }
                return response.json()
              })
              .catch(error => {
                console.log(error)
              })
          },
          allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
          if (result.value.success) {
            window.setTimeout(function(){location.reload()},1000)
          }

        })
      })

    })
</script>
@endsection
