<details class="allItems">
    <summary class="summary btn-equipment"><strong>change equipment
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
                    <!-- below we are removing "Item." prefix to make it more user friendly and easier on the eyes -->
                    <input
                        list="<?= htmlspecialchars($category) ?>_options"
                        class="equipment-input"
                        data-unit-id="<?= htmlspecialchars($unit->id) ?>"
                        data-slot="<?= htmlspecialchars($slot) ?>"
                        data-index="<?= htmlspecialchars($index) ?>"
                        value="<?= htmlspecialchars(preg_replace('/^Item\./', '', $item), ENT_QUOTES) ?>"
                        data-original="<?= htmlspecialchars(preg_replace('/^Item\./', '', $item), ENT_QUOTES) ?>"
                        placeholder="-- Select --"
                        autocomplete="off">


                    <button type="button" class="clear-btn" title="Clear">&times;</button>
                </div>


                <br>
            <?php endforeach; ?>

        </div>
    <?php endforeach; ?>
</details>