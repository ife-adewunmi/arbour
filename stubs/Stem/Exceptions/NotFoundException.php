<?php

namespace App\Stem\Exceptions;

use App\Stem\Abstracts\Exceptions\AbstractException;
use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends AbstractException
{
    protected $code = Response::HTTP_NOT_FOUND;

    protected $message = 'The requested Resource was not found.';
}
