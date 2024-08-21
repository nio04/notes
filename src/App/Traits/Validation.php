<?php

namespace App\Traits;

use App\Models\User;

/**
 * Trait ValidationTrait
 * 
 * Provides a set of validation and sanitization methods to be used within any class.
 * 
 * Methods:
 * - sanitize($data)
 * - isEmpty(array $fields, array $requiredFields = [])
 * - validateField(array $validateFields)
 * - stringValidate($data, array $rules = [])
 * - emailValidate($data)
 * - digitValidate($data)
 * - passwordValidate($data)
 * - mobileValidate($mobile, array $rules = [])
 * - getCustomErrorMessage($field, $value, $rules, $method)
 * - checkOldValue($datas)
 */
trait Validation {

  use Session;

  /**
   * Sanitize input data.
   *
   * @param mixed $data The data to be sanitized. Can be a string or an array of strings.
   * @return mixed The sanitized data. If input is an array, each element is sanitized recursively.
   * 
   * Example:
   * $input = "<script>alert('hack');</script>";
   * $sanitized = $this->sanitize($input);
   * // Result: &lt;script&gt;alert('hack');&lt;/script&gt;
   */
  public function sanitize($data) {
    if (is_array($data)) {
      return array_map([$this, 'sanitize'], $data);
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
  }

  /**
   * Check for empty required fields.
   *
   * @param array $fields The data fields to check (typically $_POST or $_GET).
   * @param array $requiredFields List of required field keys.
   * @return array An array of errors or the original $fields if no errors are found.
   * 
   * Example:
   * $fields = ['name' => 'John', 'email' => ''];
   * $required = ['name', 'email'];
   * $result = $this->isEmpty($fields, $required);
   * // Result: ["The field 'email' cannot be empty."]
   */
  public function isEmpty(array $fields, array $requiredFields = []) {
    $errors = [];

    foreach ($requiredFields as $field) {
      if (!array_key_exists($field, $fields) || empty(trim($fields[$field]))) {
        $errors[] = "The field '{$field}' cannot be empty.";
      }
    }

    return empty($errors) ? $fields : $errors;
  }

  /**
   * Validate multiple fields with custom rules.
   *
   * @param array $validateFields An associative array where each key is the field name and value is an array with 'data', 'validateMethod', and optional 'rules'.
   * @return array An array of validated data or an array of errors if validation fails.
   * 
   * Example:
   * $fields = [
   *   'username' => ['data' => 'JohnDoe', 'validateMethod' => 'stringValidate', 'rules' => ['min_length' => 3, 'max_length' => 20]],
   *   'email' => ['data' => 'john@example.com', 'validateMethod' => 'emailValidate']
   * ];
   * $result = $this->validateField($fields);
   * // Result: ['username' => 'JohnDoe', 'email' => 'john@example.com']
   */
  public function validateField(array $validateFields) {
    $errors = [];
    $validatedData = [];

    foreach ($validateFields as $fieldName => $details) {
      $value = $details['data'] ?? null;
      $method = $details['validateMethod'] ?? 'stringValidate'; // Default to 'stringValidate'
      $customRules = $details['rules'] ?? [];

      if (method_exists($this, $method)) {
        $result = $this->$method($value, $customRules);

        if ($result === false) {
          $errors[] = $this->getCustomErrorMessage($fieldName, $value, $customRules, $method);
        } else {
          $validatedData[$fieldName] = $result;
        }
      } else {
        $errors[] = "No validation method found for '{$method}' for field '{$fieldName}'.";
      }
    }

    return empty($errors) ? $validatedData : $errors;
  }

  /**
   * Validate a string with optional length constraints.
   *
   * @param string $data The string data to validate.
   * @param array $rules An associative array with 'min_length' and 'max_length' keys.
   * @return string|bool The validated string or false if validation fails.
   * 
   * Example:
   * $result = $this->stringValidate('Hello', ['min_length' => 3, 'max_length' => 10]);
   * // Result: 'Hello'
   */
  private function stringValidate($data, array $rules = []) {
    $minLength = $rules['min_length'] ?? 3;
    $maxLength = $rules['max_length'] ?? 30;

    $length = strlen($data);
    if ($length >= $minLength && $length <= $maxLength) {
      return $data;
    }

    return false;
  }

  /**
   * Validate an email address.
   *
   * @param string $data The email address to validate.
   * @return string|bool The validated email or false if validation fails.
   * 
   * Example:
   * $result = $this->emailValidate('john@example.com');
   * // Result: 'john@example.com'
   */
  private function emailValidate($data) {
    return filter_var($data, FILTER_VALIDATE_EMAIL) ? $data : false;
  }

  /**
   * Validate a string of digits.
   *
   * @param string $data The data to validate.
   * @return int|bool The validated integer or false if validation fails.
   * 
   * Example:
   * $result = $this->digitValidate('12345');
   * // Result: 12345
   */
  private function digitValidate($data) {
    return preg_match('/^\d+$/', $data) ? (int) $data : false;
  }

  /**
   * Validate a password string.
   *
   * @param string $data The password string to validate.
   * @return string|bool The validated password or false if validation fails.
   * 
   * Example:
   * $result = $this->passwordValidate('My_Passw0rd!');
   * // Result: 'My_Passw0rd!'
   */
  private function passwordValidate($data) {
    return preg_match('/^[a-zA-Z0-9_@+.]+$/', $data) ? $data : false;
  }

  /**
   * Validate a mobile number.
   *
   * @param string $mobile The mobile number to validate.
   * @param array $rules Optional rules, e.g., 'length' to specify the exact length.
   * @return string|bool The validated mobile number or false if validation fails.
   * 
   * Example:
   * $result = $this->mobileValidate('+12345678901', ['length' => 11]);
   * // Result: '+12345678901'
   */
  public function mobileValidate($mobile, $rules = []) {
    $pattern = "/^\+?[0-9]{10,15}$/";

    if (isset($rules['length'])) {
      $pattern = "/^\+?[0-9]{" . $rules['length'] . "}$/";
    }

    if (preg_match($pattern, $mobile)) {
      return $mobile;
    }

    return false;
  }

  function passwordMatches(string $pass1, string $pass2) {
    return $pass1 === $pass2 ? true : false;
  }

  function checkAlreadyExist(array $datas) {
    $errors = [];

    $user = new User();
    $user->getUsername($datas['username']) ?  $errors[] = 'username already found' : [];

    $user->getEmail($datas['email']) ?  $errors[] = 'email already found' : [];

    $user->getMobile($datas['mobile']) ? $errors[] = 'mobile number already found' : [];

    return empty($errors) ? false : $errors;
  }

  function handleFileUpload($file, $targetDir, $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf']) {
    // Sanitize file name
    $fileName = basename($file['name']);

    // Define the target file path
    $targetFile = $targetDir . $fileName;

    // Check file type extension
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Validate file type
    if (in_array($fileType, $allowedTypes)) {
      // Move file to the target directory
      if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        // File upload successful
        return [
          'success' => true,
          'file_path' => $targetFile
        ];
      } else {
        // File upload failed
        return [
          'success' => false,
          'error' => 'Failed to move uploaded file.'
        ];
      }
    } else {
      // Invalid file type
      return [
        'success' => false,
        'error' => 'Invalid file type. Allowed types are: ' . implode(', ', $allowedTypes)
      ];
    }
  }

  /**
   * Generate a custom error message based on validation method.
   *
   * @param string $field The field name being validated.
   * @param mixed $value The value of the field.
   * @param array $rules The rules applied for validation.
   * @param string $method The validation method used.
   * @return string The custom error message.
   * 
   * Example:
   * $message = $this->getCustomErrorMessage('username', 'John', ['min_length' => 3], 'stringValidate');
   * // Result: "The 'username' field must be between 3 and 30 characters long."
   */
  private function getCustomErrorMessage($field, $value, $rules, $method) {
    switch ($method) {
      case 'stringValidate':
        $minLength = $rules['min_length'] ?? 3;
        $maxLength = $rules['max_length'] ?? 30;
        return "The '{$field}' field must be between {$minLength} and {$maxLength} characters long.";

      case 'digitValidate':
        return "The '{$field}' field must contain only digits.";

      case 'mobileValidate':
        return "The '{$field}' field must be a valid mobile number.";

      case 'emailValidate':
        return "The '{$field}' field must be a valid email address.";

      case 'passwordValidate':
        return "The '{$field}' field must contain only valid characters (letters, digits, _ + . @).";

      default:
        return "The '{$field}' field is invalid.";
    }
  }
}
