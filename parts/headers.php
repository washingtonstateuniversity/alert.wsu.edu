<?php

?>
<!-- Whatever needs to be changed here can be. This is just to provide some ideas of styling to the top part of the alerts -->
<div class="notifications-wrap">
	<div class="crimson-title">
		<header><?php wsu_alert_display_status_title(); ?></header>
	</div>
	<div class="system-announcement <?php echo esc_attr( wsu_alert_level() ); ?>">
		<header>ALL WSU</header>
		<p>There are no warnings or emergencies</p>
	</div>
</div>
