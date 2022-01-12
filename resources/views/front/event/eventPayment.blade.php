@extends('front.layouts.master')

@section('head')
    @include('meta::manager', [
        'title' => 'Payment - ' . ($settings_g['title'] ?? ''),
    ])
    <style>
        .nav_transparent {
            top: 0!important;
            background: #617e7985;
        }
    </style>
@endsection

@section('master')

<div class="page_wrap">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div class="card mt-5 shadow mb-4">
                    <div class="card-header">
                        <h5>Donation Payment</h5>
                    </div>

                    <div class="card-body">
                        <p>Payment Amount: <b>{{($settings_g['currency_symbol'] ?? '$') . $eventJoin->amount }}</b></p>

                        <form role="form" action="{{route('event.payment.strip')}}" method="post" class="stripe-payment"
                            data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                            id="stripe-payment">
                            @csrf
                            <input type="hidden" name="event_join_id" value="{{ $eventJoin->id }}"/>
                            <div class="form-group">
                                <label class='control-label'>Name on Card</label>
                                <input class='form-control' size='4' type='text'>
                            </div>

                            <div class="form-group">
                                <label class='control-label'>Card Number</label>
                                <input autocomplete='off' class='form-control card-num limitthis' size='20' maxlength="16" type='number'>
                            </div>

                            <div class='form-row row'>
                                <div class='col-xs-12 col-md-4 form-group cvc required'>
                                    <label class='control-label'>CVC</label>
                                    <input autocomplete='off' class='form-control card-cvc limitthis' maxlength="3" placeholder='e.g 595' size='4' type='number'>
                                </div>

                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                    <label class='control-label'>Expiration Month</label>
                                    <input class='form-control card-expiry-month limitthis' placeholder='MM' size='2' maxlength="2" type='number'>
                                </div>
                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                    <label class='control-label'>Expiration Year</label>
                                    <input class='form-control card-expiry-year limitthis' placeholder='YYYY' maxlength="4" size='4' type='number'>
                                </div>
                            </div>

                            {{-- <div class='form-row row'>
                                <div class='col-md-12 hide error form-group'>
                                    <div class='alert-danger alert'>Fix the errors before you begin.</div>
                                </div>
                            </div> --}}

                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-success btn-lg btn-block" type="submit">Pay</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
    $(function () {
        var $form = $(".stripe-payment");
        $('form.stripe-payment').bind('submit', function (e) {
            var $form = $(".stripe-payment"),
                inputVal = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]',
                    'textarea'
                ].join(', '),
                $inputs = $form.find('.required').find(inputVal),
                $errorStatus = $form.find('div.error'),
                valid = true;
            $errorStatus.addClass('hide');

            $('.has-error').removeClass('has-error');
            $inputs.each(function (i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorStatus.removeClass('hide');
                    e.preventDefault();
                }
            });

            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                Stripe.createToken({
                    number: $('.card-num').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeRes);
            }

        });

        function stripeRes(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                var token = response['id'];
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }
    });

    // Number length limit
    $(".limitthis").on('keypress',function(e) {
        var $that = $(this);
        var maxlength = $that.attr('maxlength');
        if($.isNumeric(maxlength)){
            if($that.val().length == maxlength) { e.preventDefault(); return; }
            $that.val($that.val().substr(0, maxlength));
        };
    });
</script>
@endsection
