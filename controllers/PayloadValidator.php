<?php

class PayloadValidator
{
    private array $allowedItems;
    private int $maxPayloadSize = 1024 * 2000;

    public function __construct(array $allowedItems)
    {
        $this->allowedItems = $allowedItems;
    }

    public function validate(string $json): array
    {
        if (strlen($json) > $this->maxPayloadSize) {
            throw new Exception("Payload too large.");
        }

        $data = json_decode($json, true);
        if (!is_array($data)) {
            throw new Exception("Invalid JSON structure.");
        }

        foreach ($data as $unitId => $unitData) {
            // Skills
            if (isset($unitData['skills'])) {
                foreach ($unitData['skills'] as $skillId => $value) {
                    if (!is_numeric($value)) {
                        throw new Exception("Skill value for '$skillId' must be numeric.");
                    }
                }
            }

            // Equipment
            // if (isset($unitData['equipment'])) {
            //     foreach ($unitData['equipment'] as $slot => $items) {
            //         foreach ($items as $index => $itemId) {
            //             if ($itemId && !in_array($itemId, $this->allowedItems, true)) {
            //                 throw new Exception("Invalid item ID '$itemId' in slot '$slot'.");
            //             }
            //         }
            //     }
            // }
        }

        return $data;
    }
}
