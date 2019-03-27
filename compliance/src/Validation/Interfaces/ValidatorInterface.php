<?php

namespace Compliance\Validation\Interfaces;

use Compliance\Validation\Errors\ValidationErrorBag;

interface ValidatorInterface
{
    /**
     * Check each of the Validator's rules.
     *
     * @return bool $isValid
     */
    public function validate() : bool;

    /**
     * Consolidate each of the rule error bags into a single bag.
     *
     * @return ValidationErrroBag
     */
    public function consolidateErrorBags() : ValidationErrorBag;

    /**
     * Set a new batch of rules on the Validator.
     *
     * @param array $rules
     * @return void
     */
    public function setRules($rules);
}
