<?php
class PayloadValidator
{
    private array $allowedItemsByCategory;
    private array $slotToCategoryMap = [
        'Item0' => 'weapons',
        'Item1' => 'weapons',
        'Item2' => 'weapons',
        'Item3' => 'weapons',
        'Head' => 'head_armors',
        'Cape' => 'shoulder_armors',
        'Body' => 'body_armors',
        'Leg' => 'leg_armors',
        'Gloves' => 'gloves',
    ];
    private int $maxPayloadSize = 1024 * 2000;

    public function __construct(array $allowedItemsByCategory)
    {
        $this->allowedItemsByCategory = $allowedItemsByCategory;
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
            // Validate skills
            if (isset($unitData['skills'])) {
                foreach ($unitData['skills'] as $skillId => $value) {
                    if (!ctype_digit((string)$value) || $value < 0 || $value > 999) {
                        throw new Exception("Skill value for '$skillId' must be an integer between 0 and 999.");
                    }
                }
            }

            // Validate equipment
            if (isset($unitData['equipment'])) {
                foreach ($unitData['equipment'] as $slot => $items) {
                    if (!isset($this->slotToCategoryMap[$slot])) {
                        throw new Exception("Invalid equipment slot '$slot'.");
                    }

                    $category = $this->slotToCategoryMap[$slot];
                    $allowed = $this->allowedItemsByCategory[$category] ?? [];

                    foreach ($items as $index => $itemName) {
                        if ($itemName === '') continue;
                        if (!in_array($itemName, $allowed, true)) {
                            throw new Exception("Item '$itemName' is not allowed in slot '$slot'.");
                        }
                    }
                }
            }
        }

        return $data;
    }
}
