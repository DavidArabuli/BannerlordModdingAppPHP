<label for="skill"><?php echo $skill['id'] ?></label>
<input type="text" name="skill" id="skill" value="<?php $skill['value'] ?>">

<?php foreach ($unit->equipment as $slot => $itemArray) : ?>
    <br>
    <h3 style="border:1px solid red"><?php
                                        echo '<pre>';
                                        echo "Slot: " . $slot . "\n";
                                        print_r($itemArray);
                                        echo '</pre>';
                                        foreach ($itemArray as $item) : ?>
            <?php $inputId = "unit_{$unit->id}_item_{$item}"; ?>
            <br>
            <label for="<?= $inputId ?>">currently equipped <?= $item ?></label>
            <p>set new item: </p>
            <input type="text" name="units[<?= $unit->id ?>][items][<?= $item ?>]" value="<?= $item ?>">
        <?php endforeach; ?>


    </h3>
    <br>
<?php endforeach; ?>