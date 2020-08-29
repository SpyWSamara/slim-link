<?php

namespace App;

use App\Exceptions\SettingsSetError;
use App\Exceptions\SettingsUnsetError;

final class Settings implements \ArrayAccess
{
    /**
     * Settings storage.
     *
     * @var array
     */
    private $settings;

    /**
     * New settings object.
     *
     * @param array $settings Application settings
     */
    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Check settings path for existing.
     *
     * @param string $offset Settings path to check
     *
     * @return bool True if exists, false in other cases
     */
    public function offsetExists($offset): bool
    {
        $value = $this->settings;
        $path = \explode('.', (string) $offset);
        foreach ($path as $key) {
            if (!\array_key_exists($key, $value)) {
                return false;
            }
            $value = $value[$key];
        }

        return true;
    }

    /**
     * Get setting from path.
     *
     * @param string $offset Setting path
     *
     * @return mixed Settings values by path or null
     */
    public function offsetGet($offset)
    {
        $value = $this->settings;
        $path = \explode('.', (string) $offset);
        foreach ($path as $key) {
            if (!\array_key_exists($key, $value)) {
                return null;
            }
            $value = $value[$key];
        }

        return $value;
    }

    /**
     * Forbidden method. Settings is read only.
     *
     * @throws SettingsSetError
     *
     * @param mixed $offset Key
     * @param mixed $value  Value
     */
    public function offsetSet($offset, $value): void
    {
        throw new SettingsSetError($offset, $value);
    }

    /**
     * Forbidden method. Settings is read only.
     *
     *@throws SettingsUnsetError
     *
     * @param mixed $offset Key
     */
    public function offsetUnset($offset): void
    {
        throw new SettingsUnsetError($offset);
    }
}
