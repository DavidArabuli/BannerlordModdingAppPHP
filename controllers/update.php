<?php
function dd($data)
{
    echo '<pre>';
    die(var_dump($data));
    echo '</pre>';
}


$xmlPath = __DIR__ . '/../assets/spnpccharacters.xml';
$xmlContent = file_get_contents($xmlPath);
$xml = simplexml_load_string($xmlContent);


$json = $_POST['payload'] ?? '';
$data = json_decode($json, true);

// dd($data);
if (!is_array($data)) {
    http_response_code(400);
    exit('Invalid payload.');
}

foreach ($data as $unitId => $unitData) {

    foreach ($xml->NPCCharacter as $character) {
        $attributes = $character->attributes();
        if ((string)$attributes['id'] !== $unitId) continue;

        // === Update skills ===
        if (isset($unitData['skills'])) {
            // Removing old skills
            unset($character->skills);
            $skillsNode = $character->addChild('skills');
            foreach ($unitData['skills'] as $skillId => $value) {
                $skill = $skillsNode->addChild('skill');
                $skill->addAttribute('id', $skillId);
                $skill->addAttribute('value', $value);
            }
        }

        // === Update equipment ===
        if (isset($unitData['equipment'])) {
            $equipmentUpdates = $unitData['equipment'];
            $equipmentsNode = $character->Equipments;

            if ($equipmentsNode) {
                $rosterIndex = 0;
                foreach ($equipmentsNode->EquipmentRoster as $roster) {
                    foreach ($equipmentUpdates as $slot => $items) {
                        foreach ($items as $index => $itemId) {

                            if ((int)$index !== $rosterIndex) continue;

                            // finding existing equipment with same slot
                            $found = false;
                            foreach ($roster->equipment as $equipment) {
                                if ((string)$equipment['slot'] === $slot) {
                                    $equipment['id'] = $itemId;
                                    $found = true;
                                    break;
                                }
                            }


                            if (!$found && $itemId) {
                                $new = $roster->addChild('equipment');
                                $new->addAttribute('slot', $slot);
                                $new->addAttribute('id', $itemId);
                            }
                        }
                    }
                    $rosterIndex++;
                }
            }
        }

        break;
    }
}


$tempFile = tempnam(sys_get_temp_dir(), 'npc_') . '.xml';
$xml->asXML($tempFile);


header('Content-Type: application/xml');
header('Content-Disposition: attachment; filename="updated_npccharacters.xml"');
header('Content-Length: ' . filesize($tempFile));
readfile($tempFile);

// Clean up
unlink($tempFile);
exit;
