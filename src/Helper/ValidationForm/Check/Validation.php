<?php

namespace App\Helper\ValidationForm\Check;

use App\Helper\ValidationForm\Input;
use App\Helper\ValidationForm\Check\Validator;


/**
 * Check Form Input (syntax, min and max length etc.)
 * @return array errors
 * @return true ($this->pass) [validation passed]
 * @return false ($this->pass) [validation failed]
 */
class Validation extends Validator
{
    private $pass = false;
    private $errors = array();
    private $dbUser = null;

    public function check($source, $items = array())
    {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {
                  $value = Input::get($item);
                  $item = self::escape($item);

                if ($rule === 'required' && $rule_value == 'true' && empty($value)) {
                    $this->addError($item . ' is required');
                } elseif ($rule === 'emailformat' && $rule_value == 'true') {
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $this->addError($item . 'format is not valid');
                    }
                } elseif (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError($item . ' must be a minimum of ' . $rule_value . ' characters');
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError($item . ' must be a maximum of ' . $rule_value . ' characters');
                            }
                            break;
                        case 'matches':
                            if ($value != $source[$rule_value]) {
                                $this->addError($rule_value . ' must match ' . $item);
                            }
                            break;
                        case 'unique':
                            if ($item === 'username') {
                                $check = $this->userRepository->getUsername($value);
                            } elseif ($item === 'email') {
                                $check = $this->userRepository->getEmail($value);
                            }
                            if ($check) {
                                $this->addError($item . ' already exists.');
                            }
                            break;
                    }
                }
            }
        }

        if (empty($this->errors)) {
            $this->pass = true;
        }

        return $this;
    }

    public function addError($error)
    {
        $this->errors[] = $error;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function getPass()
    {
        return $this->pass;
    }

    private static function escape($string)
    {
        return htmlentities($string, ENT_QUOTES, 'UTF-8');
    }
}
