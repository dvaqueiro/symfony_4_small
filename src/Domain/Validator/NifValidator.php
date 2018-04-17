<?php
namespace App\Domain\Validator;

use App\Domain\Validator\Ifaces\SimpleValidator;

class NifValidator extends BasicFieldValidator implements SimpleValidator
{
    protected const DNI_REGEX = '/^(\d{8})([A-Z])$/';
    protected const CIF_REGEX = '/^([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])$/';
    protected const NIE_REGEX = '/^[XYZ]\d{7,8}[A-Z]$/';
    
    public function validate($regex = null): bool
    {
        $valid = false;
        $value = preg_replace('/\s/', '', strtoupper($this->value));
        $type = $this->getType($value);
        switch ($type) {
            case 'dni':
                $valid = $this->checkDni($value);
                break;
            case 'cif':
                $valid = $this->checkCif($value);
                break;
            case 'nie':
                $valid = $this->checkNie($value);
                break;
        }
        return $valid;
    }

    protected function getType($value): string
    {
        if (preg_match(self::DNI_REGEX, $value)) {
            return 'dni';
        }
        if (preg_match(self::CIF_REGEX, $value)) {
            return 'cif';
        }
        if (preg_match(self::NIE_REGEX, $value)) {
            return 'nie';
        }
    }

    protected function checkDni($value): bool
    {
        $dniCharacters = "TRWAGMYFPDXBNJZSQVHLCKE";
        preg_match(self::DNI_REGEX, $value, $matches, PREG_OFFSET_CAPTURE);
        $number = $matches[1] ? $matches[1][0] : 0;
        $character = $matches[2] ? $matches[2][0] : '';

        $index = $number % 23;
        $validationChar = substr($dniCharacters, $index, 1);
        return $character == $validationChar;
    }

    protected function checkNie($value): bool
    {
        $character = substr($value, 0, 1);
        $niePrefix = '';
        switch ($character) {
            case 'X':
                $niePrefix = 0;
                break;
            case 'Y':
                $niePrefix = 1;
                break;
            case 'Z':
                $niePrefix = 2;
        }

        return $this->checkDni($niePrefix . substr($value, 1));
    }

    protected function checkCif($value): bool
    {
        preg_match(self::CIF_REGEX, $value, $matches, PREG_OFFSET_CAPTURE);
        $character = $matches[1] ? $matches[1][0] : '';
        $number = $matches[2] ? $matches[2][0] : '';
        $control = $matches[3] ? $matches[3][0] : '';
        $evenSum = 0;
        $oddSum = 0;
        
        for ($i = 0; $i < strlen($number); $i++) {
            $n = (int) substr($number, $i, 1);
            if ($i % 2 == 0) {
                $n *= 2;
                $oddSum += $n < 10 ? $n : $n - 9;
            } else {
                $evenSum += $n;
            }
        }
        
        $totalSumString = (string) ($evenSum + $oddSum);
        $controlDigit = 10 - ((int) substr($totalSumString, -1, 1));
        $controlLetter = substr('JABCDEFGHI', $controlDigit, 1);
    
        // Control must be a digit
        if (preg_match('/[ABEH]/', $character)) {
            return $control == $controlDigit;
        } elseif (preg_match('/[KPQS]/', $character)) {
            return $control == $controlLetter;
        } else {
            return $control == $controlDigit || control == $controlLetter;
        }
    }
}
