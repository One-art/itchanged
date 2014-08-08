<?php

namespace ItChangedExtension;

/**
 * Abstract Class ItChangedModel
 * Example:
 *      class MyModel extends ItChangedExtension\ItChangedModel { ... }
 *
 * if you not use composer autoload insert into your index.php before yii loading
 * this line: (pls check path)
 *      include_once "./protected/extensions/itchanged/ItChangedModel.php";
 *
 * @author https://github.com/One-art
 * @version 0.1
 */
abstract class ItChangedModel extends CModel {

    private $_model_state = null;

    /**
     * @return null|array
     */
    public function getModelState() {
        return $this->_model_state;
    }

    /**
     * Save model state to private parameter
     * @param bool $force - sometimes afterFind triggered in random place, so we save only first state
     * @param array $additional_parameters
     * @return bool
     * @throws Exception
     */
    public function saveModelState($force = false, $additional_parameters = []) {
        if($this->_model_state!==null && !$force)
            return false;

        if(!is_array($additional_parameters))
            throw new Exception("Additional parameters must be an array");

        $attributes = $this->getAttributes();

        $obj_vars = get_object_vars($this);

        $this->_model_state = array_merge($obj_vars, $attributes, $additional_parameters);

        return true;
    }

    /**
     * Check attribute is changed after last save model state
     * @param $attribute
     * @return bool
     * @throws Exception
     */
    public function itChanged($attribute) {
        $model_state = $this->getModelState();
        if($model_state===null)
            throw new Exception("The model state has not been saved. Check your afterFind method.");
        elseif(!isset($model_state[$attribute]))
            throw new Exception("The attribute \"{$attribute}\" doesn't exist in state.");

        if($this->getAttribute($attribute) !== $model_state[$attribute])
            return true;
        else
            return false;
    }

    public function afterFind() {
        $this->saveModelState();
        return parent::afterFind();
    }

}