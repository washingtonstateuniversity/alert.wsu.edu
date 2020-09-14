<?php

?>
<!-- Whatever needs to be changed here can be. This is just to provide some ideas of styling to the top part of the alerts -->
<div class="notifications-wrap">
	<div class="crimson-title">
		<header><?php wsu_alert_display_status_title(); ?></header>
	</div>
	
	<div class="alert-content-area">
		<header><h1>WSU Pullman Alerts</h1></header>
		
		<?php $wsu_alerts = wsu_alert_get_latest(); ?>

		<?php if (!empty($wsu_alerts)) : ?>
			<?php foreach ($wsu_alerts as $alert) : ?>
				<?php setup_postdata( $alert ); ?>
				<section class="system-announcement-wrapper <?php echo esc_attr( wsu_get_alert_level($alert) ); ?>">
					<div class="system-announcement-container">
						<h1><?php echo esc_html( get_the_title( $alert ) ); ?></h1>
						<span class="system-announcement-date"><a href="<?php echo esc_url( get_the_permalink( $alert ) ); ?>"><?php echo esc_html( get_the_date( 'F d, Y g:ia', $alert ) ); ?></a></span>
						<div class="system-announcement-content">
							<?php the_content(''); ?>
							<a href="<?php echo esc_url( get_the_permalink( $alert ) ); ?>">Read full alert...</a>
						</div>
					</div>
				</section>
				<?php wp_reset_postdata(); ?>
			<?php endforeach; ?>
		<?php else : ?>
			<p class="no-active-alerts">There are no active alerts.</p>
		<?php endif; ?>
	</div>
</div>
