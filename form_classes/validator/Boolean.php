<?php
/**
 * Sample Static Class Validator
 */
class Boolean {

    public static function validate($value = null){
        if($value == 0 || $value == 1) {
            return true;
        }
        return false;
    }
}