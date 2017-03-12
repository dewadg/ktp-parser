<?php

namespace Dewadg\KtpParser;

require '../vendor/autoload.php';

$test = Province::find('51')->get();

var_dump($test);
