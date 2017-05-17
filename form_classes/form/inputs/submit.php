<?php
//A limited text input field
class Submit {
    public $type = 'submit';
    public $value = 'Submit';

    /**
     * @return string
     */
    public function getInput(){
        return "<input type=\"$this->type\" value=\"$this->value\"/>";
    }

    /**
     * @param $param
     * @return $this
     */
    public function setValue($param){
        $this->value = $param;
        return $this;
    }

    /**
     * @param $param
     * @return $this
     */
    public function setType($param){
        $this->type = $param;
        return $this;
    }
}
