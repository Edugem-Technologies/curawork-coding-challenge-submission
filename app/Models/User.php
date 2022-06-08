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

    public static function getAllSuggestions($lastId, $limit, $connectionRequestIds)
    {
        return self::whereNotIn('id', $connectionRequestIds)->where('id', '>', $lastId)->take($limit)->get();
    }

    public static function getLastSuggestion($connectionRequestIds)
    {
        return self::whereNotIn('id', $connectionRequestIds)->orderBy('id', 'desc')->first();
    }

    public static function getAllSentRequest($lastId, $limit, $pendingConnectionRequestIds)
    {
        return self::whereIn('id', $pendingConnectionRequestIds)->where('id', '>', $lastId)->take($limit)->get();
    }

    public static function getLastSentRequest($pendingConnectionRequestIds)
    {
        return self::whereIn('id', $pendingConnectionRequestIds)->orderBy('id', 'desc')->first();
    }

    public static function getAllReceivedRequest($lastId, $limit, $receivedConnectionRequestIds)
    {
        return self::whereIn('id', $receivedConnectionRequestIds)->where('id', '>', $lastId)->take($limit)->get();
    }

    public static function getLastReceivedRequest($receivedConnectionRequestIds)
    {
        return self::whereIn('id', $receivedConnectionRequestIds)->orderBy('id', 'desc')->first();
    }

    public static function getAllConnections($lastId, $limit, $activeConnectionRequestIdsArr)
    {
        return self::whereIn('id', $activeConnectionRequestIdsArr)->where('id', '>', $lastId)->take($limit)->get();
    }

    public static function getLastConnection($activeConnectionRequestIdsArr)
    {
        return self::whereIn('id', $activeConnectionRequestIdsArr)->orderBy('id', 'desc')->first();
    }

    public static function getUsersByIds($commonConnectionIds)
    {
        return self::whereIn('id', $commonConnectionIds)->get();
    }
}
