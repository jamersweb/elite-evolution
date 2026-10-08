<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReactionsController extends Controller
{
    public function LikePost(Request $request)
    {
        if (Auth::check()) {
            $existing = DB::table('reactions')
                ->where('user_id', Auth::id())
                ->where('reference_type', $request->type)
                ->where('reference_id', $request->id)
                ->where('type', $request->reaction)
                ->first();

            if (!$existing) {
                DB::table('reactions')->insert([
                    'reference_type' => $request->type,
                    'reference_id' => $request->id,
                    'user_id' => Auth::id(),
                    'type' => $request->reaction,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $count = DB::table('reactions')
                ->where('type', $request->reaction)
                ->where('reference_type', $request->type)
                ->where('reference_id', $request->id)
                ->count();

            return response()->json(['success' => true, 'count' => $count]);
        }

        return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
    }

    public function DislikePost(Request $request)
    {
        if (Auth::check()) {
            DB::table('reactions')
                ->where('type', $request->reaction)
                ->where('user_id', Auth::id())
                ->where('reference_type', $request->type)
                ->where('reference_id', $request->id)
                ->delete();

            $count = DB::table('reactions')
                ->where('type', $request->reaction)
                ->where('reference_type', $request->type)
                ->where('reference_id', $request->id)
                ->count();

            return response()->json(['success' => true, 'count' => $count]);
        }

        return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
    }
}
