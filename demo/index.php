<?php

require "../src/Type_B.php";

use fajar\AvanaTest\Type_B;

$typeB = new Type_B;
var_dump($typeB->validate(__DIR__ . "\Type_B.xlsx"));
