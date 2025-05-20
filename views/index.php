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
    <details class="details" closed>

        <summary class="summary btn"><strong>read more
            </strong></summary>
        <div class="instruction">
            <p>Using Bannerlord modding tools is extremely easy</p>
            <br />

            <p>1) Navigate to the unit you want to edit.</p>

            <br />

            <p>2) Enter desired values in a skill box (from 0 to 999)</p>
            <br />

            <p>
                3) If you wish to add or replace items - choose equipment roster (some
                units only have one roster), choose a slot appropriate to your desired
                item type, and choose new item from a dropdown menu. Proceed to
                another slot, next equipment roster or to another unit.
            </p>
            <br />

            <p>
                4) When you are happy with your choices - click "submit and download
                XML" button.
            </p>
            <br />

            <p>
                5) This will download an XML file, named "spnpccharacters.xml", on
                your computer.
            </p>
            <br />

            <p>
                6) Navigate to \Mount & Blade II Bannerlord\ Modules\SandBoxCore\
                ModuleData, and replace existing "spnpccharacters.xml" file with file
                produced by this app. I suggest backing up your original file, so that
                you can revert your changes.
            </p>
            <br />
            <br />
        </div>
        <div class="instruction">
            <h3 class="infoTitle">Things to know:</h3>
            <br />
            <p>
                - The file you get is fully compatible with original vanilla
                Bannerlord.
                <br />
                - It was not tested with mods that heavily modify your original game
                files.
                <br />
                - It should work in most scenarios, unless you have directly removed
                some of the items or units, or changed id-s that are used in
                "spnpccharacters.xml".
                <br />
                - Item0,1,2,3 - are slots for weapons and shields.
                <br />
                - All other have self-explaining names.
            </p>
        </div>
        <br />

    </details>

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
        document.querySelector('form').addEventListener('click', (event) => {
            if (event.target.classList.contains('clear-btn')) {
                const input = event.target.previousElementSibling;
                if (input && input.tagName.toLowerCase() === 'input') {
                    input.value = '';
                    input.dataset.cleared = 'true';
                    input.focus();
                }
            }
        });
    </script>
    <script>
        document.querySelectorAll('.equipment-input').forEach(input => {
            const datalistId = input.getAttribute('list');
            const list = document.getElementById(datalistId);
            const options = Array.from(list.options);
            const original = input.dataset.original;


            input.addEventListener('blur', () => {
                if (input.dataset.cleared === 'true') {
                    delete input.dataset.cleared;
                    return;
                }

                const isValid = options.some(option => option.value === input.value);
                if (!isValid) {
                    input.value = original;
                }
            });


            input.addEventListener('mousedown', (e) => {
                if (document.activeElement === input) {
                    e.preventDefault();


                    const val = input.value;
                    input.value = '';
                    setTimeout(() => {
                        input.value = val;
                    }, 1);
                } else {

                    input.focus();
                }



            });
        });
    </script>



</body>

</html>