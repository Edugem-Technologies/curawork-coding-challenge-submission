<?php

namespace App\Http\Controllers;

use App\Models\ConnectionRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use ResponseStatus;

class ReceivedRequestController extends Controller
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
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($lastId, $limit): JsonResponse
    {
        $userId = Auth::user()->id;
        $receivedConnectionRequestIds = ConnectionRequest::getReceivedConnectionRequests($userId)->pluck('user_id')->toArray();
        $receivedRequests = User::getAllReceivedRequest($receivedConnectionRequestIds, $lastId, $limit);

        $endOfRecords = false;
        if (!$receivedRequests->isEmpty()) {
            $lastId = getLastId($receivedRequests);
            $lastSentRequest = User::getLastReceivedRequest($receivedConnectionRequestIds);
            if (in_array($lastSentRequest->id, $receivedRequests->pluck('id')->toArray())) {
                $endOfRecords = true;
            }
        }

        $returnHTML = view('received_requests', compact('receivedRequests', 'userId', 'lastId', 'endOfRecords'))->render();

        return responseJson(true, $returnHTML, ResponseStatus::SUCCESS);
    }
}
