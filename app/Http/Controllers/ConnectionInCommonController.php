<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ResponseStatus;

class ConnectionInCommonController extends Controller
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
    public function index($lastId, $limit, $suggestionId)
    {
        $userId = Auth::user()->id;
        $commonConnectionIds = [];
        getConnectionsInCommonIds($userId, $suggestionId, $commonConnectionIds);

        $connectionsInCommon = User::getAllConnections($commonConnectionIds, $lastId, $limit);

        $endOfRecords = false;
        if (!$connectionsInCommon->isEmpty()) {
            $lastId = getLastId($connectionsInCommon);
            $lastConnection = User::getLastConnection($commonConnectionIds);
            if (in_array($lastConnection->id, $connectionsInCommon->pluck('id')->toArray())) {
                $endOfRecords = true;
            }
        }

        $returnHTML = view('connections_in_common', compact('connectionsInCommon', 'userId', 'suggestionId', 'lastId', 'endOfRecords'))->render();

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