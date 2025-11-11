<?php
class Validation {
    private $errors = [];

    public function checkFormat($value, $type, $customErrorMsg = null) {
        $patterns = [
            'first_name' => ['regex' => '/^[A-Za-z\s\'-]+$/', 'error' => 'Invalid first name'],
            'last_name' => ['regex' => '/^[A-Za-z\s\'-]+$/', 'error' => 'Invalid last name'],
            'email' => ['regex' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[A-Za-z]{2,}$/', 'error' => 'Invalid email format'],
            'password' => ['regex' => '/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', 'error' => 'Password must be 8+ chars, 1 uppercase, 1 number, 1 special']

        ];

        $pattern = $patterns[$type] ?? '/.*/';

        if (!preg_match($pattern, $value)) {
            $errorMessage = $customErrorMsg ?? "Invalid $type format.";
            $this->errors[$type] = $errorMessage;
            return false;
        }

        return true;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function hasErrors() {
        return !empty($this->errors);
    }
}
?>