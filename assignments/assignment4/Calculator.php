<?php

    class Calculator() {
        private $operator;
        private $number;
        private $number2;

            public function __construct($operator, $number, $number1) {
                $this->operator = $operator;
                $this->number = $number;
                $this->number2 = $number2;
            }

            function calc($operator, $number, $number1) {
                if ($operator == "/" && $number1 == 0) {
                    echo "The calculation is " . $number . " " . $operator . " " . $number1 . ". The answer is cannot divide a number by zero.";
                }

                if ($operator !== string || $number !== int || $number !== float || $number1 !== int || $number1 !== float ||) {
                    echo "Cannot perform operation. You must have three arguments. A string for the operator (+,-,*,/) and two integers or floats for the numbers."
                }

                if ($operator == "+") {
                    echo "The calculation is " . $number . " " . $operator . " " . $number1 . ". The answer is " . $number + $number1;
                } else if ($operator == "-") {
                    echo "The calculation is " . $number . " " . $operator . " " . $number1 . ". The answer is " . $number - $number1;
                } else if ($operator == "*") {
                    echo "The calculation is " . $number . " " . $operator . " " . $number1 . ". The answer is " . $number * $number1;
                } else if ($operator == "/") {
                    echo "The calculation is " . $number . " " . $operator . " " . $number1 . ". The answer is " . $number / $number1;
                }
            }
    }
?>