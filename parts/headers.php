<?php

?>
<!-- Whatever needs to be changed here can be. This is just to provide some ideas of styling to the top part of the alerts -->
<div class="notifications-wrap">
	<div class="crimson-title">
		<header><?php wsu_alert_display_status_title(); ?></header>
	</div>
	<div class="system-announcement-wrapper <?php echo esc_attr( wsu_alert_level() ); ?>">
		<div class="system-announcement-container">
			<?php
			if ( 'clear' === wsu_alert_level() ) {
				?>
				<header>WSU Pullman</header>
				<p>There are no warnings or emergencies</p>
				<?php
			} else {
				$active_alerts = wsu_alert_get_latest();
				$active_alert = array_shift( $active_alerts );
				setup_postdata( $active_alert );

				?>
				<header>WSU Pullman</header>
				<h1><?php echo esc_html( get_the_title( $active_alert ) ); ?></h1>
				<span class="system-announcement-date"><a href="<?php echo esc_url( get_the_permalink( $active_alert ) ); ?>"><?php echo esc_html( get_the_date( 'F d, Y g:ia' ) ); ?></a></span>
				<div class="system-announcement-content">
					<?php the_content( '<a href="' . esc_url( get_the_permalink( $active_alert ) ) . '">Read full alert...</a>' ); ?>
				</div>
				<?php
				wp_reset_postdata();
			}
			?>
		</div>
	</div>
</div>
