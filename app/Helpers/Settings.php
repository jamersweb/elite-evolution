<?php

namespace App\Helpers;
use App\Helpers\Settings;
use Auth;
use Mail;
use DB;
use Session;
class Settings{
    public static function WishList($ReferenceType,$ReferenceId)
    {
        $data = DB::table('reactions')->where('type','wishlist')->where('reference_type',$ReferenceType)->where('reference_id',$ReferenceId)->get();
        if(Auth::check()) {
            $already = DB::table('reactions')
                ->where('user_id', auth()->user()->id)
                ->where('type', 'wishlist')
                ->where('reference_type', $ReferenceType)
                ->where('reference_id', $ReferenceId)->get();
        }else{
            $already =[];
        }
        return view('frontend/snippets/wishlist-widget',compact('data','ReferenceType','ReferenceId','already'));
    }
}

