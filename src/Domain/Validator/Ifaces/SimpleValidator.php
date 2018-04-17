<?php
namespace App\Domain\Validator\Ifaces;

interface SimpleValidator
{
    public function validate($regex = null): bool;
}
