<?php

namespace Compliance\Traits;

use Compliance\Sanitization\Sanitizers\EloquentSanitizer;

trait SanitizableEloquentTrait
{
    /**
     * Run the Routines on the subject to sanitize.
     * 
     * @return mixed $subject
     */
    public function sanitize()
    {
        return EloquentSanitizer::sanitize($this, $this->sanitization());
    }
}