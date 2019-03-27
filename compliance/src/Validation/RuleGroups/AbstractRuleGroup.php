<?php

namespace Compliance\Validation\RuleGroups;

abstract class AbstractRuleGroup
{
    /**
     * The rules to check against.
     * 
     * @property array $subject
     */
    protected $rules;

    /**
     * Constructor
     * 
     * @param mixed $rules
     * @return void
     */
    public function __construct()
    {
        $this->rules = $this->setRules();
    }

    /**
     * Get the Rules.
     * 
     * @return array $rules
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Set the rules to be used in the group.
     * 
     * @return array $rules
     */
    abstract protected function setRules() : array;
}
