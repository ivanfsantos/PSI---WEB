<?php

namespace frontend\models;

class Calculadora
{
    public static function sum($num1, $num2){
        return $num1 + $num2;
    }
    public static function subtract($num1, $num2){
        return $num1 - $num2;
    }
    public static function multiply($num1, $num2){
        return $num1 * $num2;
    }
    public static function divide($num1, $num2){
        return $num1 / $num2;
    }
}