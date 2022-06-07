<?php

namespace App\Models;

use ConnectionRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConnectionRequest extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'connection_request';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'suggestion_id',
        'status',
    ];

    public static function getAllConnectionRequests($userId)
    {
        return self::where('user_id', $userId)->orWhere('suggestion_id', $userId)->get();
    }

    public static function getActiveConnectionRequests($userId)
    {
        return self::where([
                ['user_id', $userId],
                ['status', ConnectionRequestStatus::ACCEPTED]
            ])->orWhere([
                ['suggestion_id', $userId],
                ['status', ConnectionRequestStatus::ACCEPTED]
            ])->get();
    }

    public static function getPendingConnectionRequests($userId)
    {
        return self::where('user_id', $userId)->where('status', ConnectionRequestStatus::PENDING)->get();
    }

    public static function getReceivedConnectionRequests($userId)
    {
        return self::where('suggestion_id', $userId)->where('status', ConnectionRequestStatus::PENDING)->get();
    }

    public static function getByUserIDAndSuggID($userId, $suggestionId)
    {
        return self::where('user_id', $userId)->where('suggestion_id', $suggestionId)
            ->where('status', ConnectionRequestStatus::PENDING)->first();
    }
}
