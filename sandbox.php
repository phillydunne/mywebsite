<?php

echo "<p>the current working directory is: " . __DIR__ . "</p>";

echo "<p>one level up is " . "../" . __DIR__ . "</p>";

include __DIR__ . "/../../templates/test.php";

?>




