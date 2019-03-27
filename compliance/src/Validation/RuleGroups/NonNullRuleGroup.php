<?php

namespace Compliance\Validation\RuleGroups;

use Compliance\Validation\Rules\NullDataRule;
use Compliance\Validation\Rules\WhitespaceRule;
use Compliance\Validation\RuleGroups\AbstractRuleGroup;

class NonNullRuleGroup extends AbstractRuleGroup
{
    /**
     * Set the rules to be used in the group.
     * 
     * @return array $rules
     */
    protected function setRules() : array
    {
        return [
            'NullDataRule' => new NullDataRule(),
            'WhitespaceRule' => new WhitespaceRule()
        ];
    }
}