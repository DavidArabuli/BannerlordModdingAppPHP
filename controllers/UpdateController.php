<?php

class UpdateController
{

    private $xml;

    public function __construct($xml)
    {
        $this->xml = $xml;
    }

    public function readAndUpdate($data)
    {



        // $json = $_POST['payload'] ?? '';
        // $data = json_decode($json, true);

        // dd($data);

        foreach ($data as $unitId => $unitData) {

            foreach ($this->xml->NPCCharacter as $character) {
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
    }
    public function getXml(): SimpleXMLElement
    {
        return $this->xml;
    }
}
