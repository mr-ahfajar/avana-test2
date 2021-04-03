<?php

namespace fajar\AvanaTest;

require_once __DIR__ . '/../vendor/autoload.php';

use fajar\AvanaTest\ValidationInterface;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

/**
 * File Validation
 */
class FileValidation implements ValidationInterface
{
    protected $columns = [];

    /**
     * Validate a file with current class specification
     *
     * @param string $path file path that will be validated
     *
     * @return array containing result and errors
     */
    public function validate($path)
    {
        $errors = [];
        $status = false;

        if (!file_exists($path)) {
            $errors[] = "File not found";

            return [$status, $errors];
        }

        $fileParts = pathinfo($path);

        if ($fileParts["extension"] === "xlsx") {
            $reader = new Xlsx;
        } else if ($fileParts["extension"] === "xls") {
            $reader = new Xls;
        } else {
            $errors[] = "File format is unsupported";
        }

        $spreadsheet = $reader->load($path);
        $worksheet   = $spreadsheet->getActiveSheet();
        $highestRow         = $worksheet->getHighestRow();
        $highestColumn      = $worksheet->getHighestColumn();
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

        if (count($this->columns) !== $highestColumnIndex) {
            $errors[] = "Column number isn't matched";
        }

        if (!empty($errors)) {
            return [$status, $errors];
        }

        for ($i = 1; $i <= $highestColumnIndex; $i++) {
            $header = $worksheet->getCellByColumnAndRow($i, 1)->getValue();

            if ($this->columns[$i - 1] !== $header) {
                $errors[] = "Invalid Column Name at column: " . $i;
            }

            for ($j = 2; $j <= $highestRow; $j++) {
                $curValue = "" . $worksheet->getCellByColumnAndRow($i, $j)->getValue();

                if (substr($header, 0, 1) === "#") {
                    if (strpos($curValue, " ")) {
                        $errors[] = $header . " should not contain any space at row: " . $j;
                    }
                }

                if (substr($header, -1) === "*") {
                    if ($curValue === "") {
                        $errors[] = "Missing value in " . $header . " at row: " . $j;
                    }
                }
            }
        }

        $status = empty($errors);

        return [$status, $errors];
    }
}
