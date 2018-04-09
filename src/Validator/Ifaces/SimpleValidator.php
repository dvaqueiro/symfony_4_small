<?php
namespace App\Validator\Ifaces;

interface SimpleValidator
{
    public function validate($regex = null): bool;
}
