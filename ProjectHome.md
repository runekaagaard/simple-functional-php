## Introduction ##

An experiment with some of the fp (functional programming) style PHP functions. Removes the overhead of using the same create\_function() many times and supplies a basic syntax that eliminates the need of callback functions for the following PHP functions:

  * array\_reduce()
  * array\_map()
  * array\_filter()
  * array\_walk()

## Examples ##
```
<?php
// Test data.
$array1 = array(1,2,3,4,5);
$array2 = array(5,4,3,2,1);

// Multiply each value in $array1 with the corresponding value in $array2.
var_dump(map($array1, $array2, '$x,$y', '$x*$y'));

// Multiply all values in array.
var_dump(reduce($array1, '$v*$w', 1));

// Remove all array members with values below 4.
var_dump(filter($array1, '$_ < 4'));

// Insert $userdata and $key and $value times 1000 into each value.
walk($array1, '$v = "$u $k is now = " . $v * 1000', 'The value for');
var_dump($array1);
?>
```

## Usefulness ##
Even though create\_function() will only be called once per expression it still disables all benefits from opcode cache. These functions are not slow per say, but greater speed, and more maintainable code can be attained by using something like the following instead!
```
<?php
function square($array) {
  return array_map('square_', $array);
}
function square_($a) { return $a * $a; }

?>
```
And from version 5.3+ closures is a part of PHP!

## The source ##
can be found at http://code.google.com/p/simple-functional-php/source/browse/#svn/trunk.