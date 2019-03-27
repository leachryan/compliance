<?php 

namespace Compliance\Validation\Rules;

use Compliance\Validation\Errors\ValidationError;
use Compliance\Validation\Errors\ValidationErrorBag;

class NullDataRule extends AbstractRule
{
    /**
     * The check to be performed on the subject.
     * 
     * @return bool $isValid
     */
    public function validate() : bool
    {
        if($this->subject == null)
        {
            $error = new ValidationError();
            $error->subject = $this->subject;
            $error->message = $this->label !== null ? "Empty or null data is not allowed for $this->label" : "Empty or null data is not allowed";
            $error->suggestions = ['Ensure that some data is being entered. Spaces do not count.'];
            $error->rule = static::class;
            $error->field = $this->field;

            $this->errorBag->add($error);

            return false;
        }
        return true;
    }
}