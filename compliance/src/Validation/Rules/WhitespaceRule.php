<?php 

namespace Compliance\Validation\Rules;

use Compliance\Validation\Errors\ValidationError;
use Compliance\Validation\Errors\ValidationErrorBag;

class WhitespaceRule extends AbstractRule
{
    /**
     * The check to be performed on the subject.
     * 
     * @return bool $isValid
     */
    public function validate() : bool
    {
        if($this->subject == trim($this->subject))
        {
            return true;
        }
        else
        {
            $error = new ValidationError();
            $error->subject = $this->subject;
            $error->message = $this->label !== null ? "Leading or trailing whitespace is not allowed for $this->label." : 'Leading or trailing whitespace is not allowed.';
            $error->suggestions = ['Please remove any extra spaces or tabs from the beginning or end of the field.'];
            $error->rule = static::class;
            $error->field = $this->field;

            $this->errorBag->add($error);

            return false;
        }
    }
}