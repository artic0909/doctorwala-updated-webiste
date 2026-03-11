<?php
$lines = file('e:\Saklin Mustak\All Websites\Doctorwala\website\resources\views\user-medical-history.blade.php');
for ($i = 1855; $i <= 1865; $i++) {
    echo "$i: [" . $lines[$i] . "]\n";
}
