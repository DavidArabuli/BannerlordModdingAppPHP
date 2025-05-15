<?php

class UnitController
{
    public static function filterRelevantUnits(array $unit): bool
    {
        $attributes = $unit['@attributes'] ?? [];
        $occupation = $attributes['occupation'] ?? "";
        $id = $attributes['id'] ?? "";

        return ($occupation === 'Soldier' || $occupation === "Mercenary") && !str_contains($id, 'militia');
    }

    public static function extractFromXML()
    {
        $xml = file_get_contents(__DIR__ . '/../assets/spnpccharacters.xml');
        $xmlObject = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xmlObject);
        $data = json_decode($json, true);
        $allUnitsArray = $data['NPCCharacter'] ?? [];
        $finalUnitsArray = array_filter($allUnitsArray, [self::class, 'filterRelevantUnits']);

        // dd($finalUnitsArray);
        return $finalUnitsArray;
    }

    public function prepareUnits()
    {
        $data = self::extractFromXML();
        $units = [];
        foreach ($data as $unit) {
            $unit = Unit::fromArray($unit);
            $units[] =  $unit;
            // echo $unit->culture;
            // $unit->getEquipment();
        }
        return $units;
    }
    public function getSlotCategoryMap(): array
    {
        return [
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
    }
    public function getItemOptions($category)
    {
        $path = dirname(__DIR__) . "/assets/itemJsons/{$category}.json";
        if (file_exists($path)) {
            echo 'file found';
            return json_decode(file_get_contents($path), true) ?? [];
        }
        return;
    }
    public function buildOptionCache($slotCategoryMap)
    {
        $optionCache = [];
        foreach (array_unique($slotCategoryMap) as $category) {
            $optionCache[$category] = $this->getItemOptions($category);
        }
        return $optionCache;
    }

    public function index()
    {
        $slotCategoryMap = $this->getSlotCategoryMap();
        $optionCache = $this->buildOptionCache($slotCategoryMap);
        $units = $this->prepareUnits();

        $unitsByCulture = [];
        foreach ($units as $unit) {
            $unitsByCulture[$unit->culture][] = $unit;
        }

        require '../views/index.php';
    }
}
