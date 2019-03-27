<?php

namespace Compliance\Traits;

use Compliance\Validation\Validators\Validator;

trait ValidatableEloquentTrait
{
    /**
     * The validation errors.
     * 
     * @property Compliance\Validation\Errors\ValidationErrorBag $errors
     */
    protected $errors;

    /**
     * Perform the rule checks.
     * 
     * @return bool $isValid
     */
    public function validate()
    {
        $valid = true;
        
        foreach ($this->rules() as $field => $rules)
        {
            $fieldRules = [];
            if(gettype($rules) == 'object')
            {
                if( (new \ReflectionClass($rules))->isSubclassOf('Compliance\Validation\RuleGroups\AbstractRuleGroup') )
                {
                    // RuleGroup
                    foreach ($rules->getRules() as $rule)
                    {
                        if( (new \ReflectionClass($rule))->isSubclassOf('Compliance\Validation\Rules\AbstractRule') )
                        {
                            $fieldRules[] = $rule;
                        }
                    }
                }
            }
            else if(gettype($rules) === 'array')
            {
                foreach ($rules as $rule)
                {
                    if( (new \ReflectionClass($rule))->isSubclassOf('Compliance\Validation\Rules\AbstractRule') )
                    {
                        $fieldRules[] = $rule;
                    }
                    else if( (new \ReflectionClass($rule))->isSubclassOf('Compliance\Validation\RuleGroups\AbstractRuleGroup') )
                    {
                        // RuleGroup
                        foreach ($rule->getRules() as $includedRule)
                        {
                            if( (new \ReflectionClass($includedRule))->isSubclassOf('Compliance\Validation\Rules\AbstractRule') )
                            {
                                $fieldRules[] = $includedRule;
                            }
                        }
                    }
                }
            }

            foreach ($fieldRules as $rule)
            {
                $field == 'this' ? $rule->setSubject($this) : $rule->setSubject($this->{$field});
                $rule->setLabel($field);
                $rule->setField($field);
            }

            $validator = new Validator($fieldRules);

            $result = $validator->validate();

            $valid = $result ? $valid : $result;

            $this->errors = $this->errors ? $this->errors->combine($validator->consolidateErrorBags()) : $validator->consolidateErrorBags();
        }
        
        return $valid;
    }

    /**
     * Get the errors.
     */
    public function getErrors()
    {
        return $this->errors;
    }
}