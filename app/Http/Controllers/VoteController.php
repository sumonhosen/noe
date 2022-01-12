<?php

namespace App\Http\Controllers;

use App\Models\VoteAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;

class VoteController extends Controller
{
    public function store(Request $request)
    {
        Validator::make($request->all(),[
            'vote_id'=>'required|not_in:0|exists:votes,id',
            'vote_question_id'=>'not_in:0|exists:vote_questions,id',
            'answer'=>'required',
        ])->validate();

        $ip = $request->ip();
        $position = Location::get($ip);
        $data = $request->all();
        $data +=[
            'user_id'=>auth()->id(),
            'ip'=>$ip,
            'location'=>isset($position->cityName)?$position->cityName.','.$position->countryName:''
        ];
        try {
            if (auth()->check()){
                $vote = VoteAnswer::where(['vote_id'=>$request->vote_id,'user_id'=>auth()->id()])->where('user_id','!=',null)->first();
            }else{
                $vote = VoteAnswer::where(['vote_id'=>$request->vote_id,'ip'=>$ip])->where('ip','!=',null)->first();
            }
            if (isset($vote->id)) $vote->update($request->all());
            else VoteAnswer::create($data);
            return response()->json(['status'=>'success','message'=>'Vote is success'],200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','message'=>'Invalid request'],404);
        }
    }
}
