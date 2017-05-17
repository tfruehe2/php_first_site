<?php

/**
 * Class Text
 */
class Text {
    public $label;
    public $type = 'text';
    public $name;
    public $value;
    public $required = false;
    public $validator;
    public $valid = false;

    /**
     * @return string
     */
    public function getInput()
    {
        $required = $this->required ? ' required' : null;
        return "<input type=\"$this->type\" name=\"$this->name\" $required/>";
    }

    /**
     * @param $param
     * @return $this
     */
    public function setValue($param)
    {
        $this->value = $param;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $param
     * @return $this
     */
    public function setName($param)
    {
        $this->name = $param;
        return $this;
    }

    /**
     * @param $param
     * @return $this
     */
    public function setType($param)
    {
        $this->type = $param;
        return $this;
    }

    /**
     * @return $this
     */
    public function setRequired()
    {
        $this->required = true;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @return mixed
     */
    public function getLabelTag()
    {
        return "<label for=\"" . strtolower($this->label) . "\">" . ucwords($this->label) . "</label>";
    }

    /**
     * @param mixed $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return mixed
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param mixed $param
     * @return $this
     */
    public function setValidator($param)
    {
        $name = null;
        if (is_array($param)) {
            $name = key($param);
        } elseif (is_string($param)) {
            $name = ucfirst($param);
        }
        if(!$name) return false;
        require_once '../../validator/' . $name . '.php';
        $validator = new $name;
        switch (true) {
            case $validator instanceof StringLength:
                $validator->setMinimum($param['StringLength']['minimum']);
                $validator->setMaximum($param['StringLength']['maximum']);
                break;
        }
        $this->validator = $validator;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * @return $this
     */
    public function setValid()
    {
        $this->valid = true;
        return $this;
    }
}
