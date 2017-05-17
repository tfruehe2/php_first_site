<?php
/**
 * Sample Static Class Validator
 */
class StringLength {
    public static $minimum;
    public static $maximum;

    /**
     * @param null $value
     * @return bool
     */
    public static function validate($value = null){
        if(!is_string($value)
            || !self::$minimum
            || !self::$maximum)return false;
        $length = strlen($value);
        if($length <= self::$maximum && $length >= self::$minimum) {
            return true;
        }
        return false;
    }

    /**
     * @param $value
     */
    public static function setMinimum($value){
        self::$minimum = $value;
    }

    /**
     * @param $value
     */
    public static function setMaximum($value){
        self::$maximum = $value;
    }
}