<?php
namespace App\Domain\Validator;

use App\Domain\Validator\Ifaces\SimpleValidator;

class StringValidator extends BasicFieldValidator implements SimpleValidator
{
    public function validate($regex = null): bool
    {
        if ($regex) {
            return preg_match($regex, $this->value) == 1;
        } else {
            return is_string($this->value);
        }
    }
}
