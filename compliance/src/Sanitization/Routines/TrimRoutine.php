<?php

namespace Compliance\Sanitization\Routines;

class TrimRoutine extends AbstractRoutine
{
    /**
     * The routine to run on the subject.
     * 
     * @param mixed $subject
     * @return mixed $sanitized
     */
    public static function sanitize($subject)
    {
        return trim($subject);
    }
}