<?php

namespace App\Http\Controllers;

use App\Models\User;
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
    public function index($lastId, $limit): \Illuminate\Http\JsonResponse
    {
        $userId = Auth::user()->id;

        $connectionRequestIdsArr = [$userId];
        getSuggIdsForSuggestionListing($connectionRequestIdsArr, $userId);

        $suggestions = User::getAllSuggestions($connectionRequestIdsArr, $lastId, $limit);

        $endOfRecords = false;
        if (!$suggestions->isEmpty()) {
            $lastId = getLastId($suggestions);
            $lastSuggestion = User::getLastSuggestion($connectionRequestIdsArr);
            if (in_array($lastSuggestion->id, $suggestions->pluck('id')->toArray())) {
                $endOfRecords = true;
            }
        }

        $returnHTML = view('suggestions', compact('suggestions', 'userId', 'lastId', 'endOfRecords'))->render();

        return responseJson(true, $returnHTML, ResponseStatus::SUCCESS);
    }
}
