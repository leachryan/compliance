<?php

namespace Compliance\Sanitization\Routines;

class RemoveSlashesRoutine extends AbstractRoutine
{
    /**
     * The routine to run on the subject.
     * 
     * @param mixed $subject
     * @return mixed $sanitized
     */
    public static function sanitize($subject)
    {
        return str_replace('\\', '', str_replace('/', '', $subject));
    }
}