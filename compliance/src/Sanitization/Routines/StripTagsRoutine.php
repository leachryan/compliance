<?php

namespace Compliance\Sanitization\Routines;

class StripTagsRoutine extends AbstractRoutine
{
    /**
     * The routine to run on the subject.
     * 
     * @param mixed $subject
     * @return mixed $sanitized
     */
    public static function sanitize($subject)
    {
        return strip_tags($subject);
    }
}