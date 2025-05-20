<details class="allItems">
    <summary class="summary"><strong>change unit`s equipment
        </strong></summary>
    <?php
    $allSlots = ['Item0', 'Item1', 'Item2', 'Item3', 'Head', 'Body', 'Gloves', 'Leg', 'Cape'];
    foreach ($allSlots as $slot):
        $category = $slotCategoryMap[$slot] ?? 'misc';
        $items = $unit->equipment[$slot] ?? [''];
    ?>
        <div class="itemBlock">
            <h4 class="itemSlot"><?= htmlspecialchars($slot) ?> :</h4>
            <?php foreach ($items as $index => $item): ?>
                <div class="input-wrapper">
                    <input
                        list="<?= htmlspecialchars($category) ?>_options"
                        class="equipment-input"
                        data-unit-id="<?= htmlspecialchars($unit->id) ?>"
                        data-slot="<?= htmlspecialchars($slot) ?>"
                        data-index="<?= htmlspecialchars($index) ?>"
                        value="<?= htmlspecialchars($item, ENT_QUOTES) ?>"
                        data-original="<?= htmlspecialchars($item, ENT_QUOTES) ?>"
                        placeholder="-- Select --"
                        autocomplete="off">
                    <button type="button" class="clear-btn" title="Clear">&times;</button>
                </div>


                <br>
            <?php endforeach; ?>

        </div>
    <?php endforeach; ?>
</details>