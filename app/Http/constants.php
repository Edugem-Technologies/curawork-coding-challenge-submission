<?php

final class ResponseStatus
{
    const SUCCESS = 200;
    const FAILURE = 500;
}

final class ConnectionRequestStatus
{
    const PENDING = "PENDING";
    const ACCEPTED = "ACCEPTED";

    public static function getAllConnectionRequestStatus(): array
    {
        return [
            self::PENDING,
            self::ACCEPTED
        ];
    }
}
