<?php
namespace App\Validator\Ifaces;

interface FieldValidator
{
    public function validate($regex = null): bool;
}
