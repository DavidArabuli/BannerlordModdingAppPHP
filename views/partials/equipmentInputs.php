<?php
$errors = $errors ?? [];
$old = $old ?? [];
?>

<details class="allItems">
    <summary class="summary btn-equipment"><strong>change equipment</strong></summary>
    <?php
    $allSlots = ['Item0', 'Item1', 'Item2', 'Item3', 'Head', 'Body', 'Gloves', 'Leg', 'Cape'];
    foreach ($allSlots as $slot):
        $category = $slotCategoryMap[$slot] ?? 'misc';
        $defaultItems = $unit->equipment[$slot] ?? [''];
        $oldItems = $old['equipment'][$unit->id][$slot] ?? $defaultItems;
    ?>
        <div class="itemBlock">
            <h4 class="itemSlot"><?= htmlspecialchars($slot) ?> :</h4>
            <?php foreach ($oldItems as $index => $item): ?>
                <?php
                $fieldName = "equipment.{$unit->id}.{$slot}.{$index}";
                $error = $errors[$fieldName] ?? null;
                $displayItem = preg_replace('/^Item\./', '', $item);
                ?>
                <div class="input-wrapper">
                    <input
                        list="<?= htmlspecialchars($category) ?>_options"
                        class="equipment-input <?= $error ? 'error' : '' ?>"
                        data-unit-id="<?= htmlspecialchars($unit->id) ?>"
                        data-slot="<?= htmlspecialchars($slot) ?>"
                        data-index="<?= htmlspecialchars($index) ?>"
                        value="<?= htmlspecialchars($displayItem, ENT_QUOTES) ?>"
                        data-original="<?= htmlspecialchars($displayItem, ENT_QUOTES) ?>"
                        placeholder="-- Select --"
                        autocomplete="off">
                    <button type="button" class="clear-btn" title="Clear">&times;</button>
                </div>
                <?php if ($error): ?>
                    <div class="error-msg"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <br>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</details>