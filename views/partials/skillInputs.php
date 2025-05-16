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