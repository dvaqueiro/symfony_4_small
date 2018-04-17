<?php

namespace App\Domain\Validator\Ifaces;

interface EntityValidator
{
    const TYPE_INTEGER = 'integer';
    const TYPE_STRING = 'string';
    const TYPE_NIF = 'nif';
    const TYPE_DATETIME = 'datetime';

    public function validate(array $fields): bool;
    public function getErrors(): array;
}
