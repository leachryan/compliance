<?php

namespace Compliance\Validation\Rules;

use Compliance\Validation\Errors\ValidationError;
use Compliance\Validation\Errors\ValidationErrorBag;

abstract class AbstractRule
{
    /**
     * The object, array, or value to check against.
     * 
     * @property mixed $subject
     */
    protected $subject;

    /**
     * A label to represent the subject.
     * 
     * @property string $label
     */
    protected $label;

    /**
     * A field to represent a data member of an object or array.
     * 
     * @property string $field
     */
    protected $field;

    /**
     * The collection of errors that are encountered during the check.
     * 
     * @property ValidationErrorBag $errorBag
     */
    protected $errorBag;

    /**
     * Constructor
     * 
     * @param mixed $subject
     * @return void
     */
    public function __construct($subject = null, $label = null, $field = null)
    {
        $this->subject = $subject;
        $this->label = $label;
        $this->field = $field;
        $this->errorBag = new ValidationErrorBag();
    }

    /**
     * Set the subject for the rule.
     * 
     * @param mixed $subject
     * @return void
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Set the label for the rule.
     * 
     * @param string $label
     * @return void
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
    }

    /**
     * Set the field for the rule.
     * 
     * @param string $field
     * @return void
     */
    public function setField(string $field)
    {
        $this->field = $field;
    }

    /**
     * Get the ValidationErrorBag.
     * 
     * @return ValidationErrorBag
     */
    public function getErrorBag() : ValidationErrorBag
    {
        return $this->errorBag;
    }

    /**
     * The check to be performed on the subject.
     * 
     * @return bool $isValid
     */
    abstract public function validate() : bool;
}
