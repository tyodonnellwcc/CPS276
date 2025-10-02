<?php

    class Calculator {
        private $operator;
        private $number;
        private $number2;

            function calc($operator = null, $number = null, $number1 = null) {

                if ($operator === null || $number === null || $number1 === null) {
                   return "<p>Cannot perform operation. You must have three arguments. A string for the operator (+,-,*,/) and two integers or floats for the numbers.</p>";
                }

                if ($operator === "/" && $number1 == 0) {
                    return "<p>The calculation is " . $number . " " . $operator . " " . $number1 . ". The answer is cannot divide a number by zero.</p>";
                };

                if (!is_string($operator) || !in_array($operator, ["+","-","*","/"])) {
                    return "<p>Cannot perform operation. You must have a valid operator (+,-,*,/).</p>";
                }

                if (!(is_int($number) || is_float($number)) || !(is_int($number1) || is_float($number1))) {
                    return "<p>Cannot perform operation. The second and third arguments must be integers or floats.</p>";
                }

                if ($operator == "+") {
                    return "<p>The calculation is $number $operator $number1. The answer is " . $number + $number1 . ".</p>";
                } else if ($operator == "-") {
                    return "<p>The calculation is $number $operator $number1. The answer is " . $number - $number1 . ".</p>";
                } else if ($operator == "*") {
                    return "<p>The calculation is $number $operator $number1. The answer is " . $number * $number1 . ".</p>";
                } else if ($operator == "/") {
                    return "<p>The calculation is $number $operator $number1. The answer is " . $number / $number1 . ".</p>";
                };
            }
    }
?>