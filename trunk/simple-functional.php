<?php
/**
 * @file
 *   Simplified versions of array_reduce(), array_map(), array_filter() and
 *   array_walk().
 * @author Rune Kaagaard (rumi.kg@gmail.com)
 */

/**
 * Iteratively reduce the array to a single value using the variables $v and $w.
 *
 * @example
 *   // Multiply all values in array.
 *   reduce($array, '$v*$w', 1);
 * @staticvar array $cache
 * @param array $array
 *   The array that will be reduced.
 * @param string $v_w
 *   The calculations performed on each iteration.
 *     $v is value of previous array member.
 *     $w is value of current array member.
 * @param mixed $initial
 *   The initial value that will be used as the $v parameter in the first
 *   iteration.
 * @return mixed
 */
function reduce($array, $v_w, $initial=0) {
  static $cache;
  if (!isset($cache[$v_w])) {
    $cache[$v_w] = create_function('$v,$w', 'return ' . $v_w . ';');
  }
  return array_reduce((array)$array, $cache[$v_w], $initial);
}

/**
 * Applies the callback to the elements of the given arrays.
 *
 * @example
 *   // Multiply each value in $array1 with the correspoding value in $array2
 *   map($array1, $array2, '$x,$y', '$x*$y');
 * @param array $array1
 * @param array $array2
 * @param array ...
 * @param array $arrayN
 * @param string $args
 *   The code for function arguments.
 * @param string $code
 *   The function code. Uses the arguments set in $args.
 * @staticvar array $cache
 * @return array
 */
function map() {
  $args = func_get_args();
  $b = array_pop($args);
  $a = array_pop($args);
  static $cache;
  if (!isset($cache[$a][$b])) {
    $cache[$a][$b] = create_function($a, 'return' . $b . ';');
  }
  array_unshift($args, $cache[$a][$b]);
  return call_user_func_array('array_map', $args);
}

/**
 * Apply code that changes the value of every member of an array.
 *
 * @example
 *   // Insert $userdata and $key and $value times 1000 into each value.
 *   walk($array, '$v = "$u $k is now = " . $v * 1000', 'The value for');
 * @staticvar array $cache
 * @param array $array
 *   The input array. Is changed by reference.
 * @param $v_k_u
 *   The code applied on each iteration. 
 *      $v is the value. Set the value with $v = [EXPRESSION].
 *      $k is the key.
 *      $u is the $userdata send as the third parameter.
 * @param mixed $userdata
 *   Can be accessed by using $u in the second parameter.
 * @return bool
 *   Returns TRUE on success or FALSE on failure.
 */
function walk(&$array, $v_k_u, $userdata=NULL) {
  static $cache;
  if (!isset($cache[$v_k_u])) {
    $cache[$v_k_u] = create_function('&$v,$k,$u', $v_k_u . ';');
  }
  return array_walk($array, $cache[$v_k_u], $userdata);
}

/**
 * Filters elements of an array using code send in second parameter.
 *
 * @example
 *   // Remove / filter out all array members which value are below 4.
 *   filter($arr1, '$_ < 4');
 * @staticvar array $cache
 * @param array $array
 *   The array to iterate over.
 * @param string $_
 *   The filter expression.
 *     $_ is value for each array member.
 * @return array
 */
function filter($array, $_) {
  static $cache;
  if (!isset($cache[$_])) {
    $cache[$_] = create_function('$_', 'return ' . $_ . ';');
  }
  return array_filter((array)$array, $cache[$_]);
}