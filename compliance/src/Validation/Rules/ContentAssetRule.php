<?php 

namespace Compliance\Validation\Rules;

use Compliance\Validation\Errors\ValidationError;
use Compliance\Validation\Errors\ValidationErrorBag;

class ContentAssetRule extends AbstractRule
{
    /**
     * The check to be performed on the subject.
     * 
     * @return bool $isValid
     */
    public function validate() : bool
    {
        return true;
    }
}