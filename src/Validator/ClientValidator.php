<?php
namespace App\Validator;

use App\Entity\Client;
use App\Validator\Ifaces\EntityValidator;

class ClientValidator implements EntityValidator
{
    protected $fields = [
        'id' => ['type' => self::TYPE_INTEGER, 'required' => false],
        'firstname' => ['type' => self::TYPE_STRING, 'required' => true, 'max' => 128],
        'lastname' => ['type' => self::TYPE_STRING, 'required' => true, 'max' => 128],
        'nif' => ['type' => self::TYPE_NIF, 'required' => true],
        'address' => ['type' => self::TYPE_STRING, 'required' => true, 'max' => 255],
        'postcode' => ['type' => self::TYPE_STRING, 'required' => true, 'max' => 5, 'regex' => '/^[0-9]{5}$/'],
        'city' => ['type' => self::TYPE_STRING, 'required' => true, 'max' => 128],
        'state' => ['type' => self::TYPE_STRING, 'required' => true, 'max' => 128],
        'country' => ['type' => self::TYPE_STRING, 'required' => true, 'max' => 128],
        'email' => ['type' => self::TYPE_STRING, 'required' => true, 'max' => 255]
    ];

    protected $errors = [];

    public function validate(Request $request): bool
    {
        $this->errors = [];
        //TODO: Investigar una forma de validar el objeto en base a sus propiedades
        foreach ($fields as $key => $constraints) {
            if ($request->request->has($key)) {
                switch ($constraints['type']) {
                    case self::TYPE_INTEGER:
                        $validator = new IntegerValidator($request->request->$key);
                        break;
                    case self::TYPE_STRING:
                        $validator = new StringValidator($request->request->$key);
                        break;
                    case self::TYPE_NIF:
                        $validator = new NifValidator($request->request->$key);
                        break;
                    default:
                        throw new Exception('Type constraint is required when defining Fields');
                        break;
                }

                $regex = isset($constraints['regex']) ? $constraints['regex'] : null;
                if (!$validator->validate($regex)) {
                    $this->errors[] = 'Field ' . $key . ' has wrong format';
                }
            } else {
                if ($constraints['required']) {
                    $this->errors[] = 'Field ' . $key . ' is required';
                }
            }
        }

        return count($this->errors) == 0;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
