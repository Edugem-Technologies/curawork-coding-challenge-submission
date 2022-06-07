<?php

namespace App\Http\Controllers;

use App\Models\ConnectionRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ResponseStatus;

class ReceivedRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($lastId, $takeAmount): JsonResponse
    {
        $userId = Auth::user()->id;
        $receivedConnectionRequestIds = ConnectionRequest::getReceivedConnectionRequests($userId)->pluck('user_id')->toArray();
        $receivedRequests = User::getAllReceivedRequest($lastId, $takeAmount, $receivedConnectionRequestIds);

        $endOfRecords = false;
        if (!$receivedRequests->isEmpty()) {
            $lastRecord = $receivedRequests->toArray();
            $lastId = end($lastRecord)['id'];
            $lastSentRequest = User::getLastReceivedRequest($receivedConnectionRequestIds);
            if (in_array($lastSentRequest->id, $receivedRequests->pluck('id')->toArray())) {
                $endOfRecords = true;
            }
        }

        $returnHTML = view('received_requests', compact('receivedRequests', 'userId', 'lastId', 'endOfRecords'))->render();

        return responseJson(true, $returnHTML, ResponseStatus::SUCCESS);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
