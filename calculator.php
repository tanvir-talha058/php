<!DOCTYPE html>
<html>
<body>

<?php
function add_number(int $a, int $b) {
    return $a + $b;
}

function subtract_number(int $a, int $b) {
    return $a - $b;
}

function mul_number(int $a, int $b) {
    return $a * $b;
}

function div_number(int $a, int $b) {
    return $a / $b;
}

echo "Addition: " . add_number(10, 15) . "<br>";
echo "Subtraction: " . subtract_number(55, 7) . "<br>";
echo "Multiplication: " . mul_number(35, 7) . "<br>";
echo "Division: " . div_number(54, 7) . "<br>";
?>

</body>
</html>
