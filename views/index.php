<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Unit Editor</title>
    <link rel="stylesheet" href="/css/style.css">

</head>

<body>

    <?php foreach ($optionCache as $category => $options): ?>
        <datalist id="<?= htmlspecialchars($category) ?>_options">
            <?php foreach ($options as $option): ?>
                <option value="<?= htmlspecialchars($option, ENT_QUOTES) ?>"></option>
            <?php endforeach; ?>
        </datalist>
    <?php endforeach; ?>

    <h1>Unit Editor</h1>

    <form method="POST" action="/update-units" onsubmit="preparePayload(event)">
        <input type="hidden" name="payload" id="payload">
        <?php foreach ($unitsByCulture as $culture => $cultureUnits): ?>
            <div class="culture" id="culture-<?= htmlspecialchars($culture) ?>">
                <details class="details details-culture" closed>

                    <summary class="summary"><strong>
                            <?= ucfirst($culture) ?></strong> (<?= count($cultureUnits) ?> units)</summary>
                    <div class="cultureX">



                        <?php foreach ($cultureUnits as $unit): ?>
                            <div class="unitCard">




                                <h4 class="unitId"><?= htmlspecialchars($unit->id) ?></h4>

                                <div class="titleUnderscore"></div>
                                <div class="unitCardInputs">
                                    <div class="skillBox">

                                        <?php foreach ($unit->getSkillValues() as $skill): ?>
                                            <div class="inputBlock">
                                                <?= htmlspecialchars($skill['id']) ?>:
                                                <input
                                                    type="text"
                                                    class="skill-input"
                                                    data-unit-id="<?= htmlspecialchars($unit->id) ?>"
                                                    data-skill-id="<?= htmlspecialchars($skill['id']) ?>"
                                                    value="<?= htmlspecialchars($skill['value'], ENT_QUOTES) ?>">
                                            </div><br>
                                        <?php endforeach; ?>
                                    </div>
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
                                                    <input
                                                        class='inputBlock'
                                                        list="<?= htmlspecialchars($category) ?>_options"
                                                        class="equipment-input"
                                                        data-unit-id="<?= htmlspecialchars($unit->id) ?>"
                                                        data-slot="<?= htmlspecialchars($slot) ?>"
                                                        data-index="<?= htmlspecialchars($index) ?>"
                                                        value="<?= htmlspecialchars($item, ENT_QUOTES) ?>"
                                                        onfocus="this.value='';"
                                                        placeholder="-- Select --">
                                                    <br>
                                                <?php endforeach; ?>

                                            </div>
                                        <?php endforeach; ?>
                                    </details>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </details>
            </div>
        <?php endforeach; ?>



        <button type="submit">Submit</button>
    </form>

    <script>
        function preparePayload(event) {
            event.preventDefault();
            const payload = {};

            document.querySelectorAll('.skill-input').forEach(input => {
                const unitId = input.dataset.unitId;
                const skillId = input.dataset.skillId;
                const value = input.value;

                if (!payload[unitId]) payload[unitId] = {
                    skills: {},
                    equipment: {}
                };
                payload[unitId].skills[skillId] = value;
            });

            document.querySelectorAll('.equipment-input').forEach(input => {
                const unitId = input.dataset.unitId;
                const slot = input.dataset.slot;
                const index = input.dataset.index;
                const value = input.value;

                if (!payload[unitId]) payload[unitId] = {
                    skills: {},
                    equipment: {}
                };
                if (!payload[unitId].equipment[slot]) payload[unitId].equipment[slot] = [];
                payload[unitId].equipment[slot][index] = value;
            });

            document.getElementById('payload').value = JSON.stringify(payload);
            event.target.submit();
        }
    </script>

</body>

</html>