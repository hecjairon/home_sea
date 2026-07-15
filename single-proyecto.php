<?php
/**
 * Single template — Proyecto (React mount, same shell as front page).
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main" class="site-main">
	<div id="react-root"></div>
</main>
<?php
get_footer();
