<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Romainnorberg\Residue\Residue;

$code = $_POST["code"];
$code = str_replace('Residue::create', 'Romainnorberg\Residue\Residue::create', $code);

$splitMode = $_POST["splitMode"];
$decimal = $_POST["decimal"];

$eval = <<<EOT
return $code;
EOT;

$residue = eval($eval);
$result = $residue->toArray(constant('Romainnorberg\Residue\Residue::' . $splitMode));

$response = [
    'result'    => sprintf('[%s]', implode(', ', $result)), // todo: manage array with > x items
    'remainder' => $residue->getRemainder(),
    'total'     => round(array_sum($result) + $residue->getRemainder(), (int)$decimal),
];

header('Content-Type: application/json');
echo json_encode($response);
