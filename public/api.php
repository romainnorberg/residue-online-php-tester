<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Romainnorberg\Residue\Residue;

/*
$bar = <<<EOT
(new Romainnorberg\Residue\Residue(100))
      ->divideBy(3)
      ->toArray();
EOT;
*/

$bar = $_POST["code"];

$bar = str_replace('Residue::create', 'Romainnorberg\Residue\Residue::create', $bar);

$eval = <<<EOT
return $bar;
EOT;

$residue = eval($eval);
$result = $residue->toArray();

echo "<hr>";
echo "Result: ";
echo sprintf('[%s]', implode(', ', $result));

echo "<hr>";
echo "Step remainder: ";
echo var_dump($residue->getStepRemainder());

echo "<hr>";

$total = array_sum($result) + $residue->getStepRemainder();
echo "Total:";
echo $total;
