<?php

namespace App\Http\Controllers;

use App\Models\ConnectionRequest;
use App\Models\User;
use ConnectionRequestStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use ResponseStatus;

class ConnectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($lastId, $takeAmount): JsonResponse
    {
        $userId = Auth::user()->id;
        $activeConnectionRequestIds = ConnectionRequest::getActiveConnectionRequests($userId);
        $activeConnectionRequestIdsArr = [];
        if (!$activeConnectionRequestIds->isEmpty()) {
            $userIdArr = $activeConnectionRequestIds->pluck('user_id')->toArray();
            $suggestionIdArr = $activeConnectionRequestIds->pluck('suggestion_id')->toArray();
            $activeConnectionRequestIdsArr = array_merge($activeConnectionRequestIdsArr, $userIdArr, $suggestionIdArr);
            $activeConnectionRequestIdsArr = array_unique($activeConnectionRequestIdsArr);
            $position = array_search($userId, $activeConnectionRequestIdsArr);
            array_splice($activeConnectionRequestIdsArr, $position, 1);
        }

        $connections = User::getAllConnections($lastId, $takeAmount, $activeConnectionRequestIdsArr);

        $endOfRecords = false;
        if (!$connections->isEmpty()) {
            $lastRecord = $connections->toArray();
            $lastId = end($lastRecord)['id'];
            $lastConnection = User::getLastConnection($activeConnectionRequestIdsArr);
            if (in_array($lastConnection->id, $connections->pluck('id')->toArray())) {
                $endOfRecords = true;
            }
        }

        $returnHTML = view('connections', compact('connections', 'userId', 'lastId', 'endOfRecords'))->render();

        return responseJson(true, $returnHTML, ResponseStatus::SUCCESS);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
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
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        $userId = $request->input('userId');
        $connectionId = $request->input('connectionId');

        $removeActiveConnection = ConnectionRequest::where([
                ['user_id', $userId],
                ['suggestion_id', $connectionId],
                ['status', ConnectionRequestStatus::ACCEPTED]
            ])
            ->orWhere([
                ['suggestion_id', $userId],
                ['user_id', $connectionId],
                ['status', ConnectionRequestStatus::ACCEPTED]
            ])
            ->delete();

        if ($removeActiveConnection) {
            $success = true;
            $data = "";
            $status = ResponseStatus::SUCCESS;
            $message = "Connection removed successfully.";
        } else {
            $success = false;
            $data = "";
            $status = ResponseStatus::FAILURE;
            $message = "Unable to remove connection.";
        }

        return responseJson($success, $data, $status, $message);
    }
}
