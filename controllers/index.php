<?php
require_once '../controllers/UnitController.php';

require_once '../model/Unit.php';
$unitController = new UnitController;

$unitController->index();


function dd($data)
{
    echo '<pre>';
    die(var_dump($data));
    echo '</pre>';
}
