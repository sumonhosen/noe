<?php

namespace App\Http\Controllers;

use App\Models\EventJoin;
use App\Models\JoinType;
use Illuminate\Http\Request;
use Stripe;
class EventJoinController extends Controller
{
    public function eventJoin(Request $request){
        $request->validate([
            'event_id'=>'required|not_in:0|exists:events,id',
            'join_type_id'=>'required|not_in:0|exists:join_types,id',
            //'name'=>'required|string|max:191',
            //'email'=>'required|email',
            //'phone_number'=>'string',
        ]);
        $data = $request->only(['event_id','join_type_id','name','email','phone_number','amount']);
        $data +=[
            'values'=>json_encode($request->except(['_token','event_id','join_type_id','amount'])),
            'payment_status'=>'pending',
        ];
        if (auth()->check()){
            $data +=[
                'user_id'=>auth()->id(),
            ];
        }
        $event_join = EventJoin::create($data);
        $join_type = JoinType::find($request->join_type_id);
        if ($join_type->is_free ==  1){
            return redirect()->route('event.payment.page',$event_join->id);
        }else if ($join_type->is_free ==  3 && $request->amount==null){
            return redirect()->route('homepage')->with('success-alert2', 'Join successfully.');
        }else if ($join_type->is_free ==  3){
            return redirect()->route('event.payment.page',$event_join->id);
        }else{
            return redirect()->route('homepage')->with('success-alert2', 'Join successfully.');
        }
	}

    public function eventPaymentPage(EventJoin $eventJoin)
    {
        return view('front.event.eventPayment',compact('eventJoin'));
    }

    public function eventPayment(Request $request)
    {
        $donation = EventJoin::findOrFail($request->event_join_id);
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripe = Stripe\Charge::create ([
            "amount" => $donation->amount,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Event Payment"
        ]);
        if($stripe->status == 'succeeded'){
            $donation->update(['payment_status'=>1]);
            return redirect()->route('homepage')->with('success-alert2', 'Your payment successful.');
        }else{
            $donation->update(['payment_status'=>'fail']);
            return redirect()->route('homepage')->with('error-alert2', 'Your payment fail try again.');
        }
    }
}
