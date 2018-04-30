<?php

namespace App\Calendar\Infrastructure;
use App\Calendar\Application\Validator as ApplicationValidator;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator implements ApplicationValidator
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Validator constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param $value
     * @return ArrayCollection
     */
    public function validate($value)
    {
        $applicationErrors = new ArrayCollection();
        $errors = $this->validator->validate($value);
        foreach ($errors as $error)
        {
            $applicationErrors->set($error->getPropertypath(), $error->getMessage());
        }

        return $applicationErrors;
    }
}