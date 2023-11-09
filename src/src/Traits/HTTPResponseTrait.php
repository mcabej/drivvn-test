<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait HTTPResponseTrait 
{    
    private function generateCustomResponse($responseCode = 200, $errors = [], $message = '') {
        return new JsonResponse(['code' => $responseCode, 'errors' => $errors, 'message' => $message], $responseCode);
    }
}