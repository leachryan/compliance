<?php

namespace Compliance\Sanitization\Routines;

abstract class AbstractRoutine
{
    /**
     * The routine to run on the subject.
     * 
     * @param mixed $subject
     * @return mixed $sanitized
     */
    abstract public static function sanitize($subject);
}