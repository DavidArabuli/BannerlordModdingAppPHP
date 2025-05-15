<?php

class SlotController
{

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

    public function getOptionCache()
    {
        $slotCategoryMap = $this->getSlotCategoryMap();
        $optionCache = $this->buildOptionCache($slotCategoryMap);
        return $optionCache;
    }
}
