<?php

namespace fajar\AvanaTest;

require_once __DIR__ . '/../vendor/autoload.php';

use fajar\AvanaTest\FileValidation;

/**
 * Validation interface
 */
class Type_B extends FileValidation
{
    protected $columns = [
        "Field_A*",
        "#Field_B",
    ];

    /**
     * Validate a file with current class specification
     *
     * @param string $path file path that will be validated
     *
     * @return array containing result and errors
     */
    public function validate($path)
    {
        return parent::validate($path);
    }
}
