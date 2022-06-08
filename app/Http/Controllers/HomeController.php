<?php

namespace App\Http\Controllers;

use App\Models\ConnectionRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use ResponseStatus;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $userId = Auth::user()->id;

        // Get suggestion counter.
        $connectionRequestIdsArr = [$userId];
        getSuggIdsForSuggestionListing($connectionRequestIdsArr, $userId);
        $suggestionCounter = User::getAllSuggestions($connectionRequestIdsArr)->count();

        // Get sent request counter.
        $pendingConnectionRequestIds = ConnectionRequest::getPendingConnectionRequests($userId)->pluck('suggestion_id')->toArray();
        $sentRequestCounter = User::getAllSentRequest($pendingConnectionRequestIds)->count();

        // Get received request counter.
        $receivedConnectionRequestIds = ConnectionRequest::getReceivedConnectionRequests($userId)->pluck('user_id')->toArray();
        $receivedRequestCounter = User::getAllReceivedRequest($receivedConnectionRequestIds)->count();

        // Get connection counter.
        $activeConnectionRequests = ConnectionRequest::getActiveConnectionRequests($userId);
        $activeConnectionRequestIdsArr = [];
        getAllNetworkConnectionsById($activeConnectionRequestIdsArr, $activeConnectionRequests, $userId);
        $connectionCounter = User::getAllConnections($activeConnectionRequestIdsArr)->count();

        $status = ResponseStatus::SUCCESS;
        $data = [
            'suggestionCounter' => $suggestionCounter,
            'sentRequestCounter' => $sentRequestCounter,
            'receivedRequestCounter' => $receivedRequestCounter,
            'connectionCounter' => $connectionCounter,
        ];

        return responseJson(true, $data, $status, null);
    }
}
