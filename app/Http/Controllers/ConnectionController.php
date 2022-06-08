<?php

namespace App\Http\Controllers;

use App\Models\ConnectionRequest;
use App\Models\User;
use ConnectionRequestStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ResponseStatus;

class ConnectionController extends Controller
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
        $activeConnectionRequests = ConnectionRequest::getActiveConnectionRequests($userId);
        $activeConnectionRequestIdsArr = [];
        getAllNetworkConnectionsById($activeConnectionRequestIdsArr, $activeConnectionRequests, $userId);

        $connections = User::getAllConnections($activeConnectionRequestIdsArr, $lastId, $limit);

        $endOfRecords = false;
        if (!$connections->isEmpty()) {
            $connections = $connections->map(function ($item, $key) use ($userId) {
                $commonConnectionIds = [];
                getConnectionsInCommonIds($userId, $item->id, $commonConnectionIds);
                $connectionsInCommon = User::getAllConnections($commonConnectionIds);
                $item->connection_in_common_count = $connectionsInCommon->count();
                return $item;
            });

            $lastId = getLastId($connections);
            $lastConnection = User::getLastConnection($activeConnectionRequestIdsArr);
            if (in_array($lastConnection->id, $connections->pluck('id')->toArray())) {
                $endOfRecords = true;
            }
        }

        $returnHTML = view('connections', compact('connections', 'userId', 'lastId', 'endOfRecords'))->render();

        return responseJson(true, $returnHTML, ResponseStatus::SUCCESS);
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
        $suggestionId = $request->input('suggestionId');

        $removeActiveConnection = ConnectionRequest::deleteConnection($userId, $suggestionId,
            ConnectionRequestStatus::ACCEPTED);

        $success = false;
        $data = null;
        $status = ResponseStatus::FAILURE;
        $message = "Unable to remove connection.";
        if ($removeActiveConnection) {
            $success = true;
            $status = ResponseStatus::SUCCESS;
            $message = "Connection removed successfully.";
        }

        return responseJson($success, $data, $status, $message);
    }
}
