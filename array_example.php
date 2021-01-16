<?php
// php array are dynamic, we don't have to specify size of arrays and nature of data types
// so, we can add any number of element.
//
// ### 1. PHP Indexed Arrays
// # There are two ways to create index array
// #
// # (index always starts with 0)

$names = array("Ram", "Shyam", "Hari");

// # or index can be assigned manually

$names[0] = "Ram";
$names[1] = "Shyam";
$names[2] = "Hari";


echo "<pre>";
print_r($names);
var_dump($names);
echo "</pre>";


// ###### 2. Associative array
// arrays that use named keys that you assigned to them
//

$person_info['Name'] = "Ram";
$person_info['Age'] = "27";
$person_info['Gender'] = "Male";

var_dump($person_info);


// ######### 3. A multidimensional array is an array containing one or more arrays.
//
//
$cars = array(
  array("Volvo",22,18),
  array("BMW",15,13),
  array("Saab",5,2),
  array("Land Rover",17,15)
);
var_dump($cars);
