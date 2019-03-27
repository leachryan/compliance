<?php

namespace Compliance\Sanitization\Sanitizers;

use Compliance\Sanitization\Interfaces\SanitizerInterface;

class Sanitizer implements SanitizerInterface
{
    /**
     * Run each of the Routines.
     * 
     * @return mixed $subject
     */
    static function sanitize($subject, $routines) // $routines can be an array or RoutineGroup
    {
        if($routines)
        {
            if(gettype($routines) == 'object')
            {
                if( (new \ReflectionClass($routines))->isSubclassOf('Compliance\Sanitization\RoutineGroups\AbstractRoutineGroup') )
                {
                    foreach ($routines->getRoutines() as $routine)
                    {
                        if( (new \ReflectionClass($routine))->isSubclassOf('Compliance\Sanitization\Routines\AbstractRoutine') )
                        {
                            $subject = $routine::sanitize($subject);
                        }
                    }
                }
            }
            else
            {
                foreach($routines as $routine)
                {
                    if( (new \ReflectionClass($routine))->isSubclassOf('Compliance\Sanitization\Routines\AbstractRoutine') )
                    {
                        $subject = $routine::sanitize($subject);
                    }
                }
            }
        }

        return $subject;
    }
}