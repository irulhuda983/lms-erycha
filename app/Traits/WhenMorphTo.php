<?php

namespace App\Traits;

trait WhenMorphTo
{
    public function whenMorphToItem($name, $map)
    {
        try {
            return new $map[get_class($this->$name)]($this->$name);
        } catch (\Exception $e) {
            return null;
        }

    }

    public function whenMorphToCollection($name, $map)
    {
        try {
            return new $map[get_class($this->$name)]($this->$name);
        } catch (\Exception $e) {
            return null;
        }

    }
}