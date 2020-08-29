<?php

declare(strict_types=1);

namespace App\Exceptions;

class SettingsUnsetError extends Exception
{
    public function __construct($offset, int $code = 0, \Throwable $previous = null)
    {
        $message = \sptintf(
            'Settings is readonly. Try to unset key `%s`.',
            $offset
        );

        parent::__construct($message, $code, $previous);
    }
}
