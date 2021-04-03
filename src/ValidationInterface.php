<?php

namespace fajar\AvanaTest;

/**
 * Validation interface
 */
interface ValidationInterface
{
    /**
     * Validate a file with current class specification
     *
     * @param string $path file path that will be validated
     *
     * @return array containing result and errors
     */
    public function validate($path);
}