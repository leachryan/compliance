<?php 

namespace Compliance\Validation\Rules;

use Compliance\Validation\Errors\ValidationError;
use Compliance\Validation\Errors\ValidationErrorBag;

class BooleanRule extends AbstractRule
{
    /**
     * The check to be performed on the subject.
     * 
     * @return bool $isValid
     */
    public function validate() : bool
    {
        $values = [1, 0, '1', '0', true, false];

        if(!in_array($this->subject, $values))
        {
            $error = new ValidationError();
            $error->subject = $this->subject;
            $error->message = $this->label !== null ? "The value for $this->label must be true or false." : "The value must be true or false";
            $error->rule = static::class;
            $error->field = $this->field;

            $this->errorBag->add($error);

            return false;
        }

        return true;
    }
}