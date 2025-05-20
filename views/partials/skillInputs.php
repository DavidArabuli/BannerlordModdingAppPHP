<?php
$errors = $errors ?? [];
$old = $old ?? [];
?>
<div class="skillBox">
    <?php foreach ($unit->getSkillValues() as $skill): ?>
        <?php
        $unitId = $unit->id;
        $skillId = $skill['id'];
        $fieldName = "skills.$unitId.$skillId";
        $oldValue = $old['skills'][$unitId][$skillId] ?? $skill['value'];
        $error = $errors[$fieldName] ?? null;
        ?>
        <div class="inputBlock">
            <?= htmlspecialchars($skillId) ?>:
            <input
                type="text"
                class="skill-input <?= $error ? 'error' : '' ?>"
                required
                data-unit-id="<?= htmlspecialchars($unitId) ?>"
                data-skill-id="<?= htmlspecialchars($skillId) ?>"
                value="<?= htmlspecialchars($oldValue, ENT_QUOTES) ?>">
            <?php if ($error): ?>
                <div class="error-msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
        </div>
        <br>
    <?php endforeach; ?>
</div>