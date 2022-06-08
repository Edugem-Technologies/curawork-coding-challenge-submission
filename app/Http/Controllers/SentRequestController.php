<?php

namespace App\Http\Controllers;

use App\Models\ConnectionRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use ResponseStatus;

class SentRequestController extends Controller
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
        $pendingConnectionRequestIds = ConnectionRequest::getPendingConnectionRequests($userId)->pluck('suggestion_id')->toArray();
        $sentRequests = User::getAllSentRequest($pendingConnectionRequestIds, $lastId, $limit);

        $endOfRecords = false;
        if (!$sentRequests->isEmpty()) {
            $lastId = getLastId($sentRequests);
            $lastSentRequest = User::getLastSentRequest($pendingConnectionRequestIds);
            if (in_array($lastSentRequest->id, $sentRequests->pluck('id')->toArray())) {
                $endOfRecords = true;
            }
        }

        $returnHTML = view('sent_requests', compact('sentRequests', 'userId', 'lastId', 'endOfRecords'))->render();

        return responseJson(true, $returnHTML, ResponseStatus::SUCCESS);
    }
}
