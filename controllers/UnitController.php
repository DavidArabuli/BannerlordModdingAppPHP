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


    public function index()
    {
        $units = $this->prepareUnits();

        $unitsByCulture = [];
        foreach ($units as $unit) {
            $unitsByCulture[$unit->culture][] = $unit;
        }

        return $unitsByCulture;
    }
}
