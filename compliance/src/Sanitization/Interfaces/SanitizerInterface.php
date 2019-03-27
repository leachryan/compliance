<?php

namespace Compliance\Sanitization\Interfaces;

interface SanitizerInterface
{
    /**
     * Run each of the Routines.
     * 
     * @param mixed $subject
     * @param array $routines
     * @return mixed $subject
     */
    static function sanitize($subject, $routines);
}