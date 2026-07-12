<?php
/**
 * The blog sidebar.
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<aside class="sidebar lg:sticky lg:top-28" aria-label="<?php esc_attr_e( 'แถบข้าง', 'nora-learn' ); ?>">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
