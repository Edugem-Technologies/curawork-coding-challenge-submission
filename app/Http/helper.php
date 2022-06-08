<?php

use App\Models\ConnectionRequest;

// Function to send response data in json format.
function responseJson($success = true, $data = null, $status = 200, $message = null): \Illuminate\Http\JsonResponse
{
    return response()->json(array('success' => $success, 'data'=>$data, 'message' => $message), $status);
}

// Function to filter all active network connections for a user.
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

// Function to remove specific element from an array.
function removeElementFromArray(&$array, $element): void
{
    $position = array_search($element, $array);
    if (is_numeric($position)) {
        array_splice($array, $position, 1);
    }
}

// Function to get last id from the current set of records. Used for pagination.
function getLastId($result)
{
    $lastRecord = $result->toArray();
    return end($lastRecord)['id'];
}

// Function to filter connections in common for two given users.
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

function getConnectionsInCommonAllIds($userId, $suggestionIdsArr, &$commonConnectionIds): void
{
    $activeUserConnectionRequests = ConnectionRequest::getActiveConnectionRequests($userId);
    $activeUserConnectionsIdsArr = [];
    getAllNetworkConnectionsById($activeUserConnectionsIdsArr, $activeUserConnectionRequests, $userId);

    $activeSuggConnectionRequestsAll = ConnectionRequest::getActiveConnectionRequestsAllIds($suggestionIdsArr);

    foreach($activeSuggConnectionRequestsAll as $singleSuggestion) {
        $activeSuggestionConnectionsIdsArr = explode(",", $singleSuggestion->connection_ids);

        $commonConnectionIdsTemp = [];
        if (!empty($activeUserConnectionsIdsArr) && !empty($activeSuggestionConnectionsIdsArr)) {
            $commonConnectionIdsTemp = array_values(array_unique(array_intersect($activeUserConnectionsIdsArr, $activeSuggestionConnectionsIdsArr)));
        } elseif (empty($activeUserConnectionsIdsArr)) {
            $commonConnectionIdsTemp = $activeSuggestionConnectionsIdsArr;
        } elseif (empty($activeSuggestionConnectionsIdsArr)) {
            $commonConnectionIdsTemp = $activeUserConnectionsIdsArr;
        }

        if (!empty($commonConnectionIdsTemp)) {
            removeElementFromArray($commonConnectionIdsTemp, $userId);
            removeElementFromArray($commonConnectionIdsTemp, $singleSuggestion->suggestion_id);
        }

        $commonConnectionIds[$singleSuggestion->suggestion_id] = $commonConnectionIdsTemp;
    }
}

// Function to filter suggestion ids for a user.
function getSuggIdsForSuggestionListing(&$connectionRequestIdsArr, $userId): void
{
    $connectionRequestIds = ConnectionRequest::getAllConnectionRequests($userId);
    if (!$connectionRequestIds->isEmpty()) {
        $userIdArr = $connectionRequestIds->pluck('user_id')->toArray();
        $suggestionIdArr = $connectionRequestIds->pluck('suggestion_id')->toArray();
        $connectionRequestIdsArr = array_merge($connectionRequestIdsArr, $userIdArr, $suggestionIdArr);
        $connectionRequestIdsArr = array_unique($connectionRequestIdsArr);
    }
}
