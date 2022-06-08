<?php

namespace App\Http\Controllers;

use App\Models\ConnectionRequest;
use ConnectionRequestStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use ResponseStatus;

class ConnectionRequestController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $userId = $request->input('userId');
        $suggestionId = $request->input('suggestionId');

        $data = [
            'user_id' => $userId,
            'suggestion_id' => $suggestionId,
            'status' => ConnectionRequestStatus::PENDING,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $connectionRequest = ConnectionRequest::createConnectionRequest($data);

        $success = false;
        $status = ResponseStatus::FAILURE;
        $message = "Unable to send connection request.";
        if ($connectionRequest) {
            $success = true;
            $status = ResponseStatus::SUCCESS;
            $message = "Connection request sent successfully.";
        }

        return responseJson($success, null, $status, $message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $userId = $request->input('userId');
        $suggestionId = $request->input('suggestionId');

        $connectionRequest = ConnectionRequest::getByUserIDAndSuggID($userId, $suggestionId);

        $success = false;
        $status = ResponseStatus::FAILURE;
        $message = "Unable to accept connection request.";
        if (!is_null($connectionRequest)) {
            $connectionRequest->status = ConnectionRequestStatus::ACCEPTED;
            $connectionRequest->updated_at = now();
            $connectionRequest->save();
            $success = true;
            $status = ResponseStatus::SUCCESS;
            $message = "Connection request accepted successfully.";
        }

        return responseJson($success, null, $status, $message);
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
        $requestId = $request->input('requestId');

        $deleteConnectionRequest = ConnectionRequest::where('user_id', $userId)
            ->where('suggestion_id', $requestId)->where('status', ConnectionRequestStatus::PENDING)->delete();

        $success = false;
        $status = ResponseStatus::FAILURE;
        $message = "Unable to withdraw connection request.";
        if ($deleteConnectionRequest) {
            $success = true;
            $status = ResponseStatus::SUCCESS;
            $message = "Connection request withdraw successfully.";
        }

        return responseJson($success, null, $status, $message);
    }
}
