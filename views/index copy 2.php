<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Unit Editor</title>
    <link rel="stylesheet" href="/css/style.css">

</head>

<body>
    <nav class="nav">
        <div>
            <h3>Mount and Blade Bannerlord modding tools</h3>
        </div>
    </nav>

    <?php foreach ($optionCache as $category => $options): ?>
        <datalist id="<?= htmlspecialchars($category) ?>_options">
            <?php foreach ($options as $option): ?>
                <option value="<?= htmlspecialchars($option, ENT_QUOTES) ?>"></option>
            <?php endforeach; ?>
        </datalist>
    <?php endforeach; ?>

    <h1>Unit Editor</h1>

    <form class="form" method="POST" action="/update-units" onsubmit="preparePayload(event)">
        <button class="btn btn-hipster" type="submit">Submit changes and download XML</button>
        <input type="hidden" name="payload" id="payload">
        <?php foreach ($unitsByCulture as $culture => $cultureUnits): ?>
            <div class="culture" id="culture-<?= htmlspecialchars($culture) ?>">
                <details class="details" closed>

                    <summary class="summary btn"><strong>
                            <?= ucfirst($culture) ?></strong> (<?= count($cultureUnits) ?> units)</summary>
                    <div class="cultureX">



                        <?php foreach ($cultureUnits as $unit): ?>
                            <div class="unitCard">




                                <h4 class="unitId"><?= htmlspecialchars($unit->id) ?></h4>

                                <div class="titleUnderscore"></div>
                                <div class="unitCardInputs">

                                    <?php require __DIR__ . '/partials/skillInputs.php'; ?>


                                    <?php require __DIR__ . '/partials/equipmentInputs.php'; ?>


                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </details>
            </div>
        <?php endforeach; ?>




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
    <script>
        document.querySelectorAll('.equipment-input').forEach(input => {

            input.addEventListener('focus', () => {
                const currentValue = input.value;
                input.value = '';
                setTimeout(() => {
                    input.value = currentValue;
                }, 1);
            });


            input.addEventListener('blur', () => {
                const original = input.dataset.original;
                const datalistId = input.getAttribute('list');
                const list = document.getElementById(datalistId);

                const isValid = Array.from(list.options).some(option => option.value === input.value);
                if (!isValid) {
                    input.value = original;
                }
            });
        });
    </script>



</body>

</html>