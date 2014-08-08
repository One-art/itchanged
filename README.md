#ItChanged - Extension for Yii 1
=============================

This extension help to save model state before updating
and check which attribute has been changed.

For example, you want to check if user name changed or not and after update some cache and etc.
```php
public function beforeSave() {
    if($this->itChanged('username'))
        echo 'changed';
    else
        echo 'not changed';
}
```

You also can see how it changed. Use method *$this->getModelState()*
This method return associative array: *[ %attribute_name% => %attribute_value%, ... ]*

### Installation

I recommended use trait. (only for PHP >= 5.4.0)
For example:
```php
class User extends CActiveRecord {
    use ItChangedExtension\ItChangedTrait;
}
```
Simple, after use your class extending functional from trait.

But extension support old way to use throw extend.
If you have model which extend CActiveRecord, you just change extend to ItChangedActiveRecord class
Same with CForm and CModel

For import files if you not use composer, just add include_once in your index.php before yii set up.