<?php
    // function to validate inputs, takes input text and field name, echo error message if invalid
    function validateInput($input, $fieldName, $length) {
        // validate, invalid if contains sql unsafe characters, limit to 64 characters
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $input)) {
            echo "Invalid $fieldName";
            exit;
        }

        if (strlen($input) > $length) {
            echo "$fieldName too long";
            exit;
        }
    }

    function validateContent($input) {
        return htmlspecialchars($input);
    }
?>