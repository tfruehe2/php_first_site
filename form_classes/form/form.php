<?php

class Form {
  public $model;
  public $config = [];
  public $fields = [];
  public $data;
  public $isValid = false;

  public function __construct($model, array $params) {
    $this->model = $model;
    $this->config = $params;
  }

  public function getStartTag() {
    $config = $this->config;
    $form = "<form";
    $form .= $config['id'] ? " id=\"{$config['id']}\"" : null;
    $form .= $config['name'] ? " name=\"{$config['name']}\"" : null;
    $form .= $config['action'] ? " action=\"{$config['action']}\"" : null;
    $form .= $config['method'] ? " method=\"{$config['method']}\"" : null;
    $form .= ">";
    return $form;
  }

  public function generateFields() {
    $config = $this->config;
    $newField = null;
    foreach($config['fields'] as $field) {
      switch ($field['type']) {
        case 'text':
          require_once('inputs/text.php');
          $newField = new Text();
          $field['type'] ? $newField->setType($field['type']) : null;
          $field['label'] ? $newField->setLabel($field['label']) : null;
          $field['validator'] ? $newField->setValidator($field['validator']) : null;
          break;
        case 'submit':
          require_once('inputs/submit.php');
          $newField = new Submit();
          $field['type'] ? $newField->setType($field['type']) : null;
          break;
        case 'checkbox':
          require_once('inputs/checkbox.php');
          $newField = new Checkbox();
          $field['type'] ? $newField->setType($field['type']) : null;
          $field['label'] ? $newField->setLabel($field['label']) : null;
          $field['validator'] ? $newField->setValidator($field['validator']) : null;
          break;
        case "select":
        require_once('inputs/select.php');
        require_once('inputs/option.php');
        $newField = new Select();
        $option = new Option();
        $options = [];
        $values = null;
        $field['multiple'] ? $newField->setMultiple($field['multiple']) : null;
        $field['label'] ? $newField->setLabel($field['label']) : null;
        if(is_string($field['options'])){
                        $stmt = $this->model->getCountry();
                        $values = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        sort($values);
                        $options = $option->getOptions($values);
                    }
                    if(is_array($field['options'])){
                        $values = $field['options'];
                        $options = $option->getOptions($values);
                    }
                    if($options && $values){
                        $field['validator'] ? $newField->setValidator($field['validator'], $values) : null;
                        $newField->setOptions($options);
                    }
                    break;
      }

      if(!$newField) {
        return false;
      } else {
        !empty($field['value']) ? $newField->setValue($field['value']) : null;
        !empty($field['name']) ? $newField->setName($field['name']) : null;
        !empty($field['required']) ? $newField->setRequired($field['required']) : null;
        !empty($field['priority']) ? $newField->setPriority($field['priority']) : null;

      }
    }
    ksort($this->fields);
    return true;
  }

  public function setData($data) {
    $this->data = $data;
  }

  public function validate() {
    $invalidCount = null;
    foreach ($this->data as $key => $value) {
      foreach ($this->fields as $field) {
        if ($field->getName() == $key) {
          $validator = $field->getValidator();
          if($validator->validate($value)) {
            $field->setValid();
            break;
          } else {
            $invalidCount++;
          }
        }
      }
    }
    $this->isValid = $invaidCount ? false : true;
  }

  public function getFields() {
    return $this->fields;
  }

  public function getEndTag() {
    return '</form>';
  }

}

?>
