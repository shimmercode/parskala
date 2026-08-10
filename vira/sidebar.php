<?php
/**
 * Vira Theme Sidebar Template
 *
 * @package Vira
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! is_active_sidebar( 'vira-main-sidebar' ) ) {
    return;
}
?>
<aside id="secondary" class="vira-sidebar widget-area" role="complementary">
    <?php dynamic_sidebar( 'vira-main-sidebar' ); ?>
</aside>
