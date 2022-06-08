<?php

namespace Database\Seeders;

use App\Models\ConnectionRequest;
use ConnectionRequestStatus;
use Illuminate\Database\Seeder;

class ConnectionRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrIds = range(1,20);
        $arrStatus = ConnectionRequestStatus::getAllConnectionRequestStatus();

        foreach ($arrIds as $userId) {
            foreach ($arrIds as $suggestionId) {
                if ($userId != $suggestionId) {
                    $checkIfExists = ConnectionRequest::getByIds($userId, $suggestionId);
                    if(empty($checkIfExists)) {
                        $data = [
                            'user_id' => $userId,
                            'suggestion_id' => $suggestionId,
                            'status' => $arrStatus[array_rand($arrStatus)],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        ConnectionRequest::createConnectionRequest($data);
                    }
                }
            }
        }

        $arrUserIds = range(21,50);
        $arrSuggestionIds = range(1,20);
        foreach ($arrUserIds as $userId) {
            foreach ($arrSuggestionIds as $suggestionId) {
                if ($userId != $suggestionId) {
                    $checkIfExists = ConnectionRequest::getByIds($userId, $suggestionId);
                    if(empty($checkIfExists)) {
                        $data = [
                            'user_id' => $userId,
                            'suggestion_id' => $suggestionId,
                            'status' => $arrStatus[array_rand($arrStatus)],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        ConnectionRequest::createConnectionRequest($data);
                    }
                }
            }
        }
    }
}
