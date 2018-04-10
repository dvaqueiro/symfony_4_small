<?php
namespace App\Validator;

use App\Validator\Ifaces\SimpleValidator;

class IntegerValidator extends BasicFieldValidator implements SimpleValidator
{
    public function validate($regex = null): bool
    {
        if ($regex) {
            return preg_match($regex, $this->value) == 1;
        } else {
            return is_int($this->value);
        }
    }
}
