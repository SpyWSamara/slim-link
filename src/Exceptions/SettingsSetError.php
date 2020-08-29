<?php

declare(strict_types=1);

namespace App\Exceptions;

class SettingsSetError extends Exception
{
    public function __construct($offset, $value, int $code = 0, \Throwable $previous = null)
    {
        $message = \sprintf(
            'Settings is readonly. Try to set `%s` with value: `%s`.',
            $offset,
            \var_export($value, true)
        );

        parent::__construct($message, $code, $previous);
    }
}
