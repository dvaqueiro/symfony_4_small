<?php

namespace App\Validator\Ifaces;

use Symfony\Component\HttpFoundation\Request;

interface EntityValidator
{
    const TYPE_INTEGER = 'integer';
    const TYPE_STRING = 'string';
    const TYPE_NIF = 'nif';
    const TYPE_DATETIME = 'datetime';

    public function validate(Request $request): bool;
    public function getErrors(): array;
}
