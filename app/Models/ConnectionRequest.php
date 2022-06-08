<?php

namespace App\Models;

use ConnectionRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function getActiveConnectionRequestsAllIds($suggestionIdsArr): array
    {
        $query = "SELECT suggestion_id, GROUP_CONCAT(id) as connection_ids from (SELECT cr.suggestion_id as id,
          cr.user_id as suggestion_id FROM `connection_request` cr where status = '".ConnectionRequestStatus::ACCEPTED."'
          having suggestion_id in (".implode(',', $suggestionIdsArr).") UNION ALL SELECT cr.user_id as id,
          cr.suggestion_id as suggestion_id FROM `connection_request` cr where status = '".ConnectionRequestStatus::ACCEPTED."'
          having suggestion_id in (".implode(',', $suggestionIdsArr).")) as connection_ids GROUP BY suggestion_id";

        return DB::select($query);
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

    public static function getConnectionsByUserId($userId)
    {
        return self::where('user_id', $userId)
            ->where('status', ConnectionRequestStatus::ACCEPTED)
            ->get();
    }

    public static function deleteConnection($userId, $suggestionId, $status)
    {
        return self::where([
                ['user_id', $userId],
                ['suggestion_id', $suggestionId],
                ['status', $status]
            ])
            ->orWhere([
                ['suggestion_id', $userId],
                ['user_id', $suggestionId],
                ['status', $status]
            ])
            ->delete();
    }

    public static function createConnectionRequest($data)
    {
        return self::create($data);
    }
}
