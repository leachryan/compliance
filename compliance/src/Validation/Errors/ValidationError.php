<?php

namespace Compliance\Validation\Errors;

class ValidationError
{
    /**
     * The subject of the error.
     *
     * @property mixed $subject
     */
    public $subject;

    /**
     * The specific messaging or explanation of the error.
     *
     * @property string $message
     */
    public $message;

    /**
     * An array of suggestions to fix or avoid encountering the error.
     *
     * @property array $suggestions
     */
    public $suggestions;

    /**
     * The specific field that encountered the error.
     * Optional.
     *
     * @property string $field
     */
    public $field;

    /**
     * The name of the Rule that encountered the error.
     * Optional.
     *
     * @property string $rule
     */
    public $rule;
}