<?php
function dd($data)
{
    echo '<pre>';
    die(var_dump($data));
    echo '</pre>';
}

require_once __DIR__ . '/../controllers/UnitController.php';
require_once __DIR__ . '/../controllers/SlotController.php';
require_once __DIR__ . '/../controllers/UpdateController.php';
require_once __DIR__ . '/../controllers/PayloadValidator.php';
// require_once __DIR__ . '/../src/optionCache.php'; 

$xmlPath = __DIR__ . '/../assets/spnpccharacters.xml';
$xmlContent = file_get_contents($xmlPath);
$xml = simplexml_load_string($xmlContent);
if ($xml === false) {
    http_response_code(500);
    exit("Failed to load XML file.");
}
$optionCache = new SlotController()->getOptionCache();

// dd($optionCache);
// Get allowed items from the datalist cache
$allowedItems = array_merge(...array_values($optionCache));
// dd($allowedItems);
$validator = new PayloadValidator($allowedItems);

$json = $_POST['payload'] ?? '';
// dd($_POST['payload']);
if (!$json) {
    http_response_code(400);
    exit("No payload submitted.");
}
try {
    $validatedData = $validator->validate($json);
    // dd($validatedData);
} catch (Exception $e) {
    http_response_code(400);
    exit($e->getMessage());
}


$updateController = new UpdateController($xml);
$updateController->readAndUpdate($validatedData);


$tempFile = tempnam(sys_get_temp_dir(), 'npc_') . '.xml';
$updateController->getXml()->asXML($tempFile);

header('Content-Type: application/xml');
header('Content-Disposition: attachment; filename="updated_npccharacters.xml"');
header('Content-Length: ' . filesize($tempFile));
readfile($tempFile);
unlink($tempFile);
exit;
