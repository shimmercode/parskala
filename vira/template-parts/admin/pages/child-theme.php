<div class="ahura-child-page-wrapper">
    <h2><?php _e('Ahura child theme', 'ahura')?></h2>
    <?php if(!is_child_theme()): ?>
        <span class="description"><?php _e('You can automaically generate child theme for ahura', 'ahura')?></span>
        <span class="result-msg"></span>

        <a class="start-btn" href="#"><?php _e('Create child theme', 'ahura')?></a>
    <?php else: ?>
        <span class="result-msg error show"><?php _e("You can't create new child theme when child theme is already active.", 'ahura')?></span>
    <?php endif; ?>
</div>