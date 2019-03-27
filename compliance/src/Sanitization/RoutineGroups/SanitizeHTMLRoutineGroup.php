<?php

namespace Compliance\Sanitization\RoutineGroups;

use Compliance\Sanitization\RoutineGroups\AbstractRoutineGroup;
use Compliance\Sanitization\Routines\RemoveSlashesRoutine;
use Compliance\Sanitization\Routines\StripTagsRoutine;
use Compliance\Sanitization\Routines\TrimRoutine;

class SanitizeHTMLRoutineGroup extends AbstractRoutineGroup
{
    /**
     * Set the Routines to be used in the group.
     * 
     * @return array $routines
     */
    protected function setRoutines() : array
    {
        return [
            RemoveSlashesRoutine::class,
            StripTagsRoutine::class,
            TrimRoutine::class
        ];
    }
}