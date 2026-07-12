<?php
/**
 * Breadcrumb band — sits below the header on inner pages.
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;

if ( is_front_page() ) {
	return;
}
?>
<div class="border-b border-paper-200 bg-paper-100/60">
	<?php nora_learn_breadcrumb(); ?>
</div>
