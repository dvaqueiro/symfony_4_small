<?php
namespace App\Validator;

abstract class BasicFieldValidator
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }
}
