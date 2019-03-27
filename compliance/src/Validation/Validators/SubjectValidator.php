<?php

namespace Compliance\Validation\Validators;

use Compliance\Validation\Validators\Validator;

class SubjectValidator extends Validator
{
    /**
     * The subject to be passed to each rule.
     *
     * @property array $subject
     */
    protected $subject = null;

    /**
     * Constructor
     *
     * @param mixed $subject
     * @param mixed $rules
     * @return void
     */
    public function __construct($subject = null, $rules = []) // rules can be a RuleGroup or an array
    {
        $this->subject = $subject;

        $this->setRules($rules);
    }

    /**
     * Set the subject of the rules.
     * 
     * @param mixed $subject
     * @return void
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Get the subject of the rules.
     * 
     * @return mixed @subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Check each of the Validator's rules.
     *
     * @return bool $isValid
     */
    public function validate() : bool
    {
        $isValid = true;

        foreach($this->rules as $rule)
        {
            $rule->setSubject($this->subject);
            $isValid = $rule->validate() == false ? false : $isValid;
        }

        return $isValid;
    }
}
