<?php

namespace Compliance\Sanitization\RoutineGroups;

abstract class AbstractRoutineGroup
{
    /**
     * The Routines to run on a subject.
     * 
     * @property array $routines
     */
    protected $routines;

    /**
     * Constructor.
     * 
     * @param array $routines
     * @return void
     */
    public function __construct()
    {
        $this->routines = $this->setRoutines();
    }

    /**
     * Get the Routines.
     * 
     * @return array $routines
     */
    public function getRoutines()
    {
        return $this->routines;
    }

    /**
     * Set the Routines to be used in the group.
     * 
     * @return array $routines
     */
    abstract protected function setRoutines() : array;
}