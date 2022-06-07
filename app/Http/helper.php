<?php

use App\Models\ConnectionRequest;
use App\Models\User;

function responseJson($success = true, $data = null, $status = 200, $message = null): \Illuminate\Http\JsonResponse
{
    return response()->json(array('success' => $success, 'data'=>$data, 'message' => $message), $status);
}

function getAllNetworkConnectionsById(&$activeConnectionIdsArr, $activeConnectionRequests, $userId): void
{
    if (!$activeConnectionRequests->isEmpty()) {
        $userIdArr = $activeConnectionRequests->pluck('user_id')->toArray();
        $suggestionIdArr = $activeConnectionRequests->pluck('suggestion_id')->toArray();
        $activeConnectionIdsArr = array_merge($activeConnectionIdsArr, $userIdArr, $suggestionIdArr);
        $activeConnectionIdsArr = array_values(array_unique($activeConnectionIdsArr));
        removeElementFromArray($activeConnectionIdsArr, $userId);
    }
}

function removeElementFromArray(&$array, $element): void
{
    $position = array_search($element, $array);
    if (is_numeric($position)) {
        array_splice($array, $position, 1);
    }
}

function getLastId($result)
{
    $lastRecord = $result->toArray();
    return end($lastRecord)['id'];
}

function getConnectionsInCommonIds($userId, $suggestionId, &$commonConnectionIds): void
{
    $activeUserConnectionRequests = ConnectionRequest::getActiveConnectionRequests($userId);
    $activeSuggConnectionRequests = ConnectionRequest::getActiveConnectionRequests($suggestionId);
    $activeUserConnectionsIdsArr = [];
    $activeSuggestionConnectionsIdsArr = [];
    getAllNetworkConnectionsById($activeUserConnectionsIdsArr, $activeUserConnectionRequests, $userId);
    getAllNetworkConnectionsById($activeSuggestionConnectionsIdsArr, $activeSuggConnectionRequests, (int)$suggestionId);

    if (!empty($activeUserConnectionsIdsArr) && !empty($activeSuggestionConnectionsIdsArr)) {
        $commonConnectionIds = array_values(array_unique(array_intersect($activeUserConnectionsIdsArr, $activeSuggestionConnectionsIdsArr)));
    } elseif (empty($activeUserConnectionsIdsArr)) {
        $commonConnectionIds = $activeSuggestionConnectionsIdsArr;
    } elseif (empty($activeSuggestionConnectionsIdsArr)) {
        $commonConnectionIds = $activeUserConnectionsIdsArr;
    }

    if (!empty($commonConnectionIds)) {
        removeElementFromArray($commonConnectionIds, $userId);
        removeElementFromArray($commonConnectionIds, (int)$suggestionId);
    }
}
