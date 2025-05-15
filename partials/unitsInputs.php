<label for="skill"><?php echo $unitID ?></label>
<input type="text" name="skill" id="skill" value="<?php $unitID ?>">
<label for="<?= $inputId ?>"><?= $item['id'] ?></label>
<input type="text" name="units[<?= $unit->id ?>][skills][<?= $skill['id'] ?>]" id="<?= $inputId ?>" value="<?= $skill['value'] ?>">
<?php foreach ($units as $unit) : ?>
    <br>
    <h3><?= $unit->id ?></h3>
    <br>
    <?php foreach ($unit->getSkillValues() as $skill) : ?>
        <?php $inputId = "unit_{$unit->id}_skill_{$skill['id']}"; ?>
        <br>
        <label for="<?= $inputId ?>"><?= $skill['id'] ?></label>
        <input type="text" name="units[<?= $unit->id ?>][skills][<?= $skill['id'] ?>]" id="<?= $inputId ?>" value="<?= $skill['value'] ?>">
        <br>
    <?php endforeach; ?>
    <?php $allSlots = ['Item0', 'Item1', 'Item2', 'Item3', 'Head', 'Body', 'Gloves', 'Leg', 'Cape']; ?>
    <?php foreach ($allSlots as $slot): ?>
        <?php

        $items = $unit->equipment[$slot] ?? [];
        $options = $optionCache[$category] ?? [];

        ?>
        <div>
            <h3><?php echo $slot; ?></h3>
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $index => $item): ?>
                    <input type="text" name="equipment[<?php echo $slot; ?>][]" value="<?php echo htmlspecialchars($item); ?>">
                <?php endforeach; ?>
            <?php else: ?>

                <input type="text" name="equipment[<?php echo $slot; ?>][]" value="">
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>

<?php
echo '<pre>';
print_r($optionCache);
echo '</pre>';
?>