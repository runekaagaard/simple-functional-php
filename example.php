<?php

//testing
$array1 = array(1,2,3,4,5);
$array2 = array(5,4,3,2,1);

echo "### Testing map ###\n";
var_dump(map($array1, $array2, '$x,$y', '$x*$y'));

echo "\n### Testing reduce ###\n";
var_dump(reduce($array1, '$v*$w', 1));

echo "\n### Testing filter ###\n";
var_dump(filter($array1, '$_ < 4'));

echo "\n### Testing walk ###\n";
walk($array1, '$v = "$u $k is now = " . $v * 1000', 'The value for');
var_dump($array1);