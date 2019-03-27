<?php

namespace Compliance\Sanitization\Sanitizers;

use Compliance\Sanitization\Sanitizers\Sanitizer;

class EloquentSanitizer extends Sanitizer
{
    /**
     * Run each of the Routines.
     * 
     * @return mixed $subject
     */
    static function sanitize($model, $config) // $routines can be an array or RoutineGroup
    {
        foreach ($config as $field => $routines)
        {
            if(gettype($routines) == 'object')
            {
                if( (new \ReflectionClass($routines))->isSubclassOf('Compliance\Sanitization\RoutineGroups\AbstractRoutineGroup') )
                {
                    foreach ($routines->getRoutines() as $routine)
                    {
                        if( (new \ReflectionClass($routine))->isSubclassOf('Compliance\Sanitization\Routines\AbstractRoutine') )
                        {
                            $model->{$field} = $routine::sanitize($model->{$field});
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
                        $model->{$field} = $routine::sanitize($model->{$field});
                    }
                    else if( (new \ReflectionClass($routine))->isSubclassOf('Compliance\Sanitization\RoutineGroups\AbstractRoutineGroup') )
                    {
                        foreach ($routine->getRoutines() as $includedRoutine)
                        {
                            if( (new \ReflectionClass($includedRoutine))->isSubclassOf('Compliance\Sanitization\Routines\AbstractRoutine') )
                            {
                                $model->{$field} = $includedRoutine::sanitize($model->{$field});
                            }
                        }
                    }
                }
            }
        }

        return $model;
    }
}