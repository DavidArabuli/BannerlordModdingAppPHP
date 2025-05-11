<?php

class Unit
{
    public string $id;
    public array $skills;
    public array $equipment;
    public static function fromArray(array $data): self
    {
        $unit = new self;
        $unit->id = $data['@attributes']['id'] ?? '';
        $unit->skills = $data['skills'] ?? [];
        $unit->equipment = $data['Equipments'] ?? [];
        $unit->equipment = $unit->getNormalizedEquipment();

        return $unit;
    }
    public function getSkillValues()
    {

        // echo '<pre>';
        // print_r($this->skills);
        // print_r($this->skills);
        // echo '</pre>';
        $skillsValues = [];
        foreach ($this->skills['skill'] as $skill) {
            $skillsValues[] = [
                'id' => $skill['@attributes']['id'] ?? 'unknown',
                'value' => $skill['@attributes']['value'] ?? 0,
            ];
            // echo '<pre>';
            // echo $this->id;
            // print_r($this->skills);
            // print_r($skill);
            // echo '</pre>';
        }
        return $skillsValues;
    }

    public function getEquipment()
    {

        echo '<pre>';
        echo $this->id;
        print_r($this->equipment);
        // print_r($this->equipment["EquipmentRoster"][0]['equipment']);
        // ['equipment'][0]['@attributes']['id']
        echo '</pre>';
    }
    public function getNormalizedEquipment(): array
    {
        $normalized = [];


        $rosters = $this->equipment['EquipmentRoster'] ?? [];


        if (isset($rosters['equipment'])) {
            $rosters = [$rosters];
        }


        foreach ($rosters as $roster) {
            $items = $roster['equipment'] ?? [];


            if (isset($items['@attributes'])) {
                $items = [$items];
            }


            foreach ($items as $item) {
                $slot = $item['@attributes']['slot'] ?? 'Unknown';
                $id = $item['@attributes']['id'] ?? 'Unknown';

                $normalized[$slot][] = $id;
            }
        }

        return $normalized;
    }
}
