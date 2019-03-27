<?php

namespace Compliance\Validation\Errors;

use Compliance\Validation\Errors\ValidationError;

class ValidationErrorBag
{
    /**
     * The underlying array of ValidationErrors;
     *
     * @property array $errors;
     */
    protected $errors;

    public function __construct($errors = null)
    {
        if($errors)
        {
            $this->errors = $errors;
        }
        else
        {
            $this->errors = [];
        }
    }

    /**
     * Add a ValidationError to the bag.
     *
     * @param Compliance\Validation\Errors\ValidationError
     * @return void
     */
    public function add(ValidationError $error)
    {
        $this->errors[] = $error;
    }

    /**
     * Return the underlying error array.
     *
     * @return array $errors
     */
    public function all() : array
    {
        return $this->errors;
    }

    /**
     * Return the count of the underlying error array.
     *
     * @return int $count
     */
    public function count() : int
    {
        return count($this->errors);
    }

    /**
     * Clear the errors from the bag.
     *
     * @return void
     */
    public function clear()
    {
        $this->errors = [];
    }

    /**
     * Remove an error from the bag by index.
     *
     * @param int $index
     * @return void
     */
    public function remove($index)
    {
        $this->errors = \array_splice($this->errors, $index, 1);
    }

    /**
     * Return an array of only error messages.
     *
     * @return array $errors
     */
    public function messages()
    {
        $messages = [];

        foreach($this->errors as $error)
        {
            $messages[] = $error->message;
        }

        return $messages;
    }

    /**
     * Combine with another error bag.
     * 
     * @return Compliance\Validation\Errors\ValidationErrorBag
     */
    public function combine(ValidationErrorBag $bag) : ValidationErrorBag
    {
        foreach ($bag->all() as $error)
        {
            $this->add($error);
        }

        return $this;
    }
}