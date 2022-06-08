<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getAllSuggestions($connectionRequestIds, $lastId = null, $limit = null)
    {
        $result = self::whereNotIn('id', $connectionRequestIds);

        if (!is_null($lastId) && $lastId >= 1) {
            $result = $result->where('id', '<', $lastId);
        }
        if (!is_null($limit)) {
            $result = $result->take($limit);
        }

        return $result->orderBy('id', 'desc')->get();
    }

    public static function getLastSuggestion($connectionRequestIds)
    {
        return self::whereNotIn('id', $connectionRequestIds)->orderBy('id', 'asc')->first();
    }

    public static function getAllSentRequest($pendingConnectionRequestIds, $lastId = null, $limit = null)
    {
        $result = self::whereIn('id', $pendingConnectionRequestIds);

        if (!is_null($lastId) && $lastId >= 1) {
            $result = $result->where('id', '<', $lastId);
        }
        if (!is_null($limit)) {
            $result = $result->take($limit);
        }

        return $result->orderBy('id', 'desc')->get();
    }

    public static function getLastSentRequest($pendingConnectionRequestIds)
    {
        return self::whereIn('id', $pendingConnectionRequestIds)->orderBy('id', 'asc')->first();
    }

    public static function getAllReceivedRequest($receivedConnectionRequestIds, $lastId = null, $limit = null)
    {
        $result = self::whereIn('id', $receivedConnectionRequestIds);

        if (!is_null($lastId) && $lastId >= 1) {
            $result = $result->where('id', '<', $lastId);
        }
        if (!is_null($limit)) {
            $result = $result->take($limit);
        }

        return $result->orderBy('id', 'desc')->get();
    }

    public static function getLastReceivedRequest($receivedConnectionRequestIds)
    {
        return self::whereIn('id', $receivedConnectionRequestIds)->orderBy('id', 'asc')->first();
    }

    public static function getAllConnections($activeConnectionRequestIdsArr, $lastId = null, $limit = null)
    {
        $result = self::whereIn('id', $activeConnectionRequestIdsArr);

        if (!is_null($lastId) && $lastId >= 1) {
            $result = $result->where('id', '<', $lastId);
        }
        if (!is_null($limit)) {
            $result = $result->take($limit);
        }

        return $result->orderBy('id', 'desc')->get();
    }

    public static function getLastConnection($activeConnectionRequestIdsArr)
    {
        return self::whereIn('id', $activeConnectionRequestIdsArr)->orderBy('id', 'asc')->first();
    }
}
