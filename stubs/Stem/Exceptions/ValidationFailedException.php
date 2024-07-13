<?php

namespace App\Stem\Exceptions;

use App\Stem\Abstracts\Exceptions\AbstractException;
use Symfony\Component\HttpFoundation\Response;

class ValidationFailedException extends AbstractException
{
    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;

    protected $message = 'Invalid Input.';
}
