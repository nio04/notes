<?php

namespace App\Traits;

/**
 * Trait SessionTrait
 *
 * Provides utility methods for handling session operations, including starting sessions,
 * getting, setting, checking, removing session data, and managing session lifecycle.
 */
trait Session {
  static public function startSession(): void {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
  }

  /**
   * Get a session value.
   *
   * Retrieves the value associated with the provided key from the session. Supports
   * nested keys if an array of keys is provided.
   *
   * @param string|array $key The session key or an array of keys for nested values.
   * @param mixed $default The default value to return if the key is not found.
   * @return mixed The session value or the default value.
   *
   * Example Usage:
   * ```php
   * // For single key
   * $value = $this->getSession('user_id');
   *
   * // For nested key
   * $value = $this->getSession(['user', 'name']);
   * ```
   */
  static public function getSession($key, $default = null) {
    self::startSession();

    if (is_array($key)) {
      return self::getNestedValue($_SESSION, $key, $default);
    }

    return $_SESSION[$key] ?? $default;
  }

  /**
   * Set a session value.
   *
   * Stores a value in the session under the provided key. Supports nested keys
   * if an array of keys is provided.
   *
   * @param string|array $key The session key or an array of keys for nested values.
   * @param mixed $value The value to store in the session.
   *
   * Example Usage:
   * ```php
   * // For single key
   * $this->setSession('user_id', 123);
   *
   * // For nested key
   * $this->setSession(['user', 'name'], 'John Doe');
   * ```
   */
  static public function setSession($key, $value): void {
    self::startSession();

    if (is_array($key)) {
      self::setNestedValue($_SESSION, $key, $value);
    } else {
      $_SESSION[$key] = $value;
    }
  }

  /**
   * Check if a session key exists.
   *
   * Determines if a key exists in the session. Supports nested keys
   * if an array of keys is provided.
   *
   * @param string|array $key The session key or an array of keys for nested values.
   * @return bool True if the key exists, false otherwise.
   *
   * Example Usage:
   * ```php
   * // For single key
   * $exists = $this->hasSession('user_id');
   *
   * // For nested key
   * $exists = $this->hasSession(['user', 'name']);
   * ```
   */
  static public function hasSession($key): bool {
    self::startSession();

    if (is_array($key)) {
      return self::hasNestedValue($_SESSION, $key);
    }

    return isset($_SESSION[$key]);
  }

  /**
   * Remove a session key.
   *
   * Removes a value from the session under the provided key. Supports nested keys
   * if an array of keys is provided.
   *
   * @param string|array $key The session key or an array of keys for nested values.
   *
   * Example Usage:
   * ```php
   * // For single key
   * $this->removeSession('user_id');
   *
   * // For nested key
   * $this->removeSession(['user', 'name']);
   * ```
   */
  static public function removeSession($key): void {
    self::startSession();

    if (is_array($key)) {
      self::removeNestedValue($_SESSION, $key);
    } else {
      unset($_SESSION[$key]);
    }
  }

  /**
   * Clear all session data.
   *
   * Removes all data from the current session.
   *
   * Example Usage:
   * ```php
   * $this->clearSession();
   * ```
   */
  static public function clearSession(): void {
    self::startSession();
    session_unset();
  }

  /**
   * Destroy the current session.
   *
   * Ends the current session and removes all session data.
   *
   * Example Usage:
   * ```php
   * $this->destroySession();
   * ```
   */
  static public function destroySession(): void {
    self::startSession();
    session_destroy();
  }

  /**
   * Regenerate the session ID.
   *
   * Regenerates the session ID to prevent session fixation attacks.
   *
   * @param bool $deleteOldSession Whether to delete the old session or not.
   *
   * Example Usage:
   * ```php
   * $this->regenerateSessionId(); // Regenerates and deletes the old session
   * ```
   */
  static public function regenerateSessionId(bool $deleteOldSession = true): void {
    self::startSession();
    session_regenerate_id($deleteOldSession);
  }

  /**
   * Retrieve a nested value from an array or object.
   *
   * This is an internal utility method used by `getSession` and other methods to
   * retrieve nested values based on an array of keys.
   *
   * @param array|object $data The array or object to retrieve the value from.
   * @param array $keys An array of keys to traverse.
   * @param mixed $default The default value to return if the key is not found.
   * @return mixed The retrieved value or the default value.
   */
  private static function getNestedValue($data, array $keys, $default) {
    foreach ($keys as $key) {
      if (is_array($data) && array_key_exists($key, $data)) {
        $data = $data[$key];
      } elseif (is_object($data) && property_exists($data, $key)) {
        $data = $data->$key;
      } else {
        return $default; // Key not found, return default
      }
    }

    return $data;
  }

  /**
   * Set a nested value in an array or object.
   *
   * This is an internal utility method used by `setSession` to set nested values
   * based on an array of keys.
   *
   * @param array|object &$data The array or object to set the value in.
   * @param array $keys An array of keys to traverse.
   * @param mixed $value The value to set.
   */
  private static function setNestedValue(&$data, array $keys, $value): void {
    foreach ($keys as $key) {
      if (is_array($data)) {
        if (!isset($data[$key]) || !is_array($data[$key])) {
          $data[$key] = [];
        }
        $data = &$data[$key];
      } elseif (is_object($data)) {
        if (!property_exists($data, $key) || !is_object($data->$key)) {
          $data->$key = new \stdClass();
        }
        $data = &$data->$key;
      } else {
        return; // Invalid structure, exit
      }
    }

    $data = $value;
  }

  /**
   * Check if a nested value exists in an array or object.
   *
   * This is an internal utility method used by `hasSession` to check for the existence
   * of nested values based on an array of keys.
   *
   * @param array|object $data The array or object to check.
   * @param array $keys An array of keys to traverse.
   * @return bool True if the nested value exists, false otherwise.
   */
  private static function hasNestedValue($data, array $keys): bool {
    foreach ($keys as $key) {
      if (is_array($data) && array_key_exists($key, $data)) {
        $data = $data[$key];
      } elseif (is_object($data) && property_exists($data, $key)) {
        $data = $data->$key;
      } else {
        return false; // Key not found
      }
    }

    return true; // All keys exist
  }

  /**
   * Remove a nested value from an array or object.
   *
   * This is an internal utility method used by `removeSession` to remove nested values
   * based on an array of keys.
   *
   * @param array|object &$data The array or object to remove the value from.
   * @param array $keys An array of keys to traverse.
   */
  private static function removeNestedValue(&$data, array $keys): void {
    $key = array_shift($keys);

    if (is_array($data)) {
      if (isset($data[$key])) {
        if (empty($keys)) {
          unset($data[$key]);
        } else {
          self::removeNestedValue($data[$key], $keys);
        }
      }
    } elseif (is_object($data)) {
      if (property_exists($data, $key)) {
        if (empty($keys)) {
          unset($data->$key);
        } else {
          self::removeNestedValue($data->$key, $keys);
        }
      }
    }
  }
}
