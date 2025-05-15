<?php
require_once '../controllers/SlotController.php';
require_once '../controllers/UnitController.php';

require_once '../model/Unit.php';
$slotController = new SlotController();
$optionCache = $slotController->getOptionCache();
$slotCategoryMap = $slotController->getSlotCategoryMap();
$unitController = new UnitController;

$unitsByCulture = $unitController->index();


function dd($data)
{
    echo '<pre>';
    die(var_dump($data));
    echo '</pre>';
}
// dd($optionCache);
require '../views/index.php';
