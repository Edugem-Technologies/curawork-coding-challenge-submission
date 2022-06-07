<?php

namespace App\Http\Controllers;

use App\Models\ConnectionRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use ResponseStatus;

class SuggestionController extends Controller
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($lastId, $takeAmount): \Illuminate\Http\JsonResponse
    {
        $userId = Auth::user()->id;
        $connectionRequestIds = ConnectionRequest::getAllConnectionRequests($userId);
        $connectionRequestIdsArr = [$userId];
        if (!$connectionRequestIds->isEmpty()) {
            $userIdArr = $connectionRequestIds->pluck('user_id')->toArray();
            $suggestionIdArr = $connectionRequestIds->pluck('suggestion_id')->toArray();
            $connectionRequestIdsArr = array_merge($connectionRequestIdsArr, $userIdArr, $suggestionIdArr);
            $connectionRequestIdsArr = array_unique($connectionRequestIdsArr);
        }

        $suggestions = User::getAllSuggestions($lastId, $takeAmount, $connectionRequestIdsArr);

        $endOfRecords = false;
        if (!$suggestions->isEmpty()) {
            $lastRecord = $suggestions->toArray();
            $lastId = end($lastRecord)['id'];
            $lastSuggestion = User::getLastSuggestion($connectionRequestIdsArr);
            if (in_array($lastSuggestion->id, $suggestions->pluck('id')->toArray())) {
                $endOfRecords = true;
            }
        }

        $returnHTML = view('suggestions', compact('suggestions', 'userId', 'lastId', 'endOfRecords'))->render();

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
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
