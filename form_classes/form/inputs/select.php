<?php
//A limited text input field
class Select {
    public $label;
    public $name;
    public $required = false;
    public $multiple = false;
    public $options = [];
    public $validator;
    public $valid = false;

    public function getInput(){
        $select = "<select";
        $select .= $this->name ? " name=\"$this->name\"":null;
        $select .= $this->required ? " required":null;
        $select .= $this->multiple ? " multiple":null;
        $select .= ">";
        foreach($this->options as $option){
            $select .= $option;
        }
        $select .= "</select>";
        return $select;
    }

    /**
     * @return boolean
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @param boolean $required
     * @return $this
     */
    public function setRequired($required)
    {
        $this->required = $required;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isMultiple()
    {
        return $this->multiple;
    }

    /**
     * @param boolean $multiple
     * @return $this
     */
    public function setMultiple($multiple)
    {
        $this->multiple = $multiple;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
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
     * @param mixed $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelTag()
    {
        return "<label for=\"". strtolower($this->label) . "\">" . ucwords($this->label) . "</label>";
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
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
     * @param mixed $param
     * @param $values
     * @return $this
     */
    public function setValidator($param, $values)
    {
        /** @noinspection PhpIncludeInspection */
        require_once '../../validator/' . $param . '.php';
        $validator = new $param;
        switch (true){
            case ($validator instanceof InArray):
                $validator->setValues($values);
            break;
        }
        $this->validator = $validator;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValidator()
    {
        return $this->validator;
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
