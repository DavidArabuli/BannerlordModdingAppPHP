<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php foreach ($optionCache as $category => $options): ?>
        <datalist id="<?= $category ?>_options">
            <?php foreach ($options as $option): ?>
                <option value="<?= htmlspecialchars($option) ?>"></option>
            <?php endforeach; ?>
        </datalist>
    <?php endforeach; ?>
    Welcome to the home page!
    <form action="/update-units" method="POST">

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
                $category = $slotCategoryMap[$slot] ?? 'misc';
                $options = $optionCache[$category] ?? [];

                $items = $unit->equipment[$slot] ?? [''];
                ?>
                <div>
                    <h3><?php echo htmlspecialchars($slot); ?></h3>
                    <?php foreach ($items as $index => $item): ?>
                        <input
                            list="<?= $category ?>_options"
                            name="equipment[<?= $unit->id ?>][<?= $index ?>][<?= $slot ?>]"
                            value="<?= htmlspecialchars($item) ?>"
                            data-original="<?= htmlspecialchars($item) ?>"
                            onfocus="this.value='';"

                            placeholder="-- Select --" />

                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

        <?php endforeach; ?>

        <button type="submit">submit</button>
    </form>
</body>

</html>