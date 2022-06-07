<?php

function responseJson($success = true, $data = "", $status = 200, $message = ""): \Illuminate\Http\JsonResponse
{
    return response()->json(array('success' => $success, 'data'=>$data, 'message' => $message), $status);
}
