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
session_start();

$xmlPath = __DIR__ . '/../assets/spnpccharacters.xml';
$xmlContent = file_get_contents($xmlPath);
$xml = simplexml_load_string($xmlContent);
if ($xml === false) {
    http_response_code(500);
    exit("Failed to load XML file.");
}
$optionCache = new SlotController()->getOptionCache();

// dd($optionCache);

$allowedItems = array_merge(...array_values($optionCache));
// dd($allowedItems);
// dd($optionCache);
$validator = new PayloadValidator($optionCache);

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
    $_SESSION['errors'] = ['global' => $e->getMessage()];
    $_SESSION['old'] = $_POST;
    header("Location: /index.php");
    exit;
}
if (!empty($validator->errors)) {
    $_SESSION['errors'] = $validator->errors;
    $_SESSION['old'] = $_POST;
    header("Location: /");
    exit;
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
