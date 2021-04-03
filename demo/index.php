<?php

require "../src/Type_A.php";

use fajar\AvanaTest\Type_A;

$typeB = new Type_A;
var_dump($typeB->validate(__DIR__ . "\Type_A.xlsx"));
