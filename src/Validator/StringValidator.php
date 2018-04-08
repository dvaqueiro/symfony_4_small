<?php
namespace App\Validator;

use App\Entity\Client;
use App\Validator\Ifaces\SimpleValidator;

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
