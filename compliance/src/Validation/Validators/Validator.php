<?php

namespace Compliance\Validation\Validators;

use Compliance\Validation\Interfaces\ValidatorInterface;
use Compliance\Validation\Errors\ValidationErrorBag;

class Validator implements ValidatorInterface
{
    /**
     * The array of rules to be checked.
     *
     * @property array $rules
     */
    public $rules = [];

    /**
     * Constructor
     *
     * @param mixed $subject
     * @param array $rules
     * @return void
     */
    public function __construct($rules = null)
    {
        $this->setRules($rules);
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
            $isValid = $rule->validate() == false ? false : $isValid;
        }

        return $isValid;
    }

    /**
     * Set a new batch of rules on the Validator.
     *
     * @param array $rules
     * @return void
     */
    public function setRules($rules)
    {
        if($rules)
        {
            if(gettype($rules) == 'object')
            {
                if( (new \ReflectionClass($rules))->isSubclassOf('Compliance\Validation\RuleGroups\AbstractRuleGroup') )
                {
                    $this->rules = [];
                    // RuleGroup
                    foreach ($rules->getRules() as $rule)
                    {
                        if( (new \ReflectionClass($rule))->isSubclassOf('Compliance\Validation\Rules\AbstractRule') )
                        {
                            $this->rules[] = $rule;
                        }
                    }
                }
            }
            else if(gettype($rules) === 'array')
            {
                $this->rules = [];
                foreach ($rules as $rule)
                {
                    if( (new \ReflectionClass($rule))->isSubclassOf('Compliance\Validation\Rules\AbstractRule') )
                    {
                        $this->rules[] = $rule;
                    }
                }
            }
        }
    }

    /**
     * Consolidate each of the rule error bags into a single bag.
     *
     * @return ValidationErrorBag
     */
    public function consolidateErrorBags() : ValidationErrorBag
    {
        $consolidatedBag = [];

        foreach($this->rules as $rule)
        {
            $consolidatedBag = array_merge($consolidatedBag, $rule->getErrorBag()->all());
        }

        return new ValidationErrorBag($consolidatedBag);
    }
}
