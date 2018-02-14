<?php

namespace CyberWorks\Core\Validation;

use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
    protected $errors;

    public function validate($request, array $rules)
    {
        foreach ($rules as $field => $rule)
        {
            try {
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            } catch (NestedValidationException $ex) {
                $this->errors[$field] = $ex->getMessages();
            }
        }

        $_SESSION['errors'] = $this->errors;

        return $this;
    }

    public function validateArgs($args, array $rules)
    {
        foreach ($rules as $field => $rule)
        {
            try {
                $rule->setName(ucfirst($field))->assert($args[$field]);
            } catch (NestedValidationException $ex) {
                $this->errors[$field] = $ex->getMessages();
            }
        }

        $_SESSION['errors'] = $this->errors;

        return $this;
    }

    public function failed() {
        return !empty($this->errors);
    }

    public function errors() {
        return $this->errors;
    }
}