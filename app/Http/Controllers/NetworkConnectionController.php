<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Friend;

class NetworkConnectionController extends Controller
{
    public function index()
    {
        return view('network-connection');
    }

    public function getSuggestions(Request $request)
    {
        $suggestions = User::whereDoesntHave('friendsTo', function ($q) {
                          return $q->where('user_id', Auth::user()->id);
                        })
                        ->whereDoesntHave('friendsFrom', function ($q) {
                          return $q->where('user_id', Auth::user()->id);
                        })
                        ->where('id', '<>', Auth::user()->id)
                        ->paginate(10);
        return response()->json(['suggestions' => $suggestions], 200);
    }

    public function connect(Request $request)
    {
        // dd($request->all());
        $connect = Friend::create([
            'user_id' => Auth::user()->id,
            'friend_id' => $request->id,
        ]);
        if ($connect) {
            return response()->json(['message' => 'Request submitted successfully'], 200);
        }else{
            return response()->json(['message' => 'Something went wrong, try again later.'], 500);
        }
    }

    public function getSentRequests(Request $request)
    {
        $sent_requests = Auth::user()
                        ->pendingFriendsTo()
                        ->paginate(10);
        return response()->json(['sent_requests' => $sent_requests], 200);
    }

    public function withdrawRequest(Request $request)
    {
        // dd($request->all());
        $withdraw_request = Friend::where('user_id', Auth::user()->id)
                            ->where('friend_id', $request->id)
                            ->delete();
        if ($withdraw_request) {
            return response()->json(['message' => 'Request withdrawed successfully'], 200);
        }else{
            return response()->json(['message' => 'Something went wrong, try again later.'], 500);
        }
    }

    public function getReceivedRequests(Request $request)
    {
        $received_requests = Auth::user()
                        ->pendingFriendsFrom()
                        ->paginate(10);
        return response()->json(['received_requests' => $received_requests], 200);
    }

    public function acceptRequest(Request $request)
    {
        // dd($request->all());
        $accept_request = Friend::where('user_id', $request->id )
                            ->where('friend_id',Auth::user()->id)
                            ->update([
                                'accepted' => 1
                            ]);
        if ($accept_request) {
            return response()->json(['message' => 'Request accepted successfully'], 200);
        }else{
            return response()->json(['message' => 'Something went wrong, try again later.'], 500);
        }
    }

    public function getConnections(Request $request)
    {
        $connections = Auth::user()
                        ->friends()
                        ->paginate(10);
        // dd($connections);
        return response()->json(['connections' => $connections], 200);
    }

    public function removeConnection(Request $request)
    {
        // dd($request->all());
        $remove_connection = Friend::where(function($q) use($request){
                                return $q->where('user_id', Auth::user()->id)
                                            ->where('friend_id', $request->id);
                            })->orWhere(function($q) use($request){
                                return $q->where('friend_id', Auth::user()->id)
                                            ->where('user_id', $request->id);
                            })
                            ->delete();
        // dd($remove_connection);
        if ($remove_connection) {
            return response()->json(['message' => 'Connection removed successfully'], 200);
        }else{
            return response()->json(['message' => 'Something went wrong, try again later.'], 500);
        }
    }

    public function getAllCounts(){
        $suggestions = User::whereDoesntHave('friendsTo', function ($q) {
            return $q->where('user_id', Auth::user()->id);
          })
          ->whereDoesntHave('friendsFrom', function ($q) {
            return $q->where('user_id', Auth::user()->id);
          })
          ->where('id', '<>', Auth::user()->id)
          ->count();
        
        $sent_requests = Auth::user()
                        ->pendingFriendsTo()
                        ->count();

        $received_requests = Auth::user()
                            ->pendingFriendsFrom()
                            ->count();
        $connections = Auth::user()
                            ->friends()
                            ->count();

        return $data = [
            'suggestions'           => $suggestions,
            'sent_requests'         => $sent_requests,
            'received_requests'     => $received_requests,
            'connections'           => $connections,
        ];
    }

}
