<?php
/**
 * Sample Static Class Validator
 */
class InArray {

    public static $values = [];
    public static function validate($value = null){
        if(self::$values && in_array($value, self::$values)) {
            return true;
        }
        return false;
    }

    public static function setValues(array $values){
        self::$values = $values;
    }
}