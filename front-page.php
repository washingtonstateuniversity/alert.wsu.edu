<?php

get_header();
?>
	<main>
		<?php get_template_part( 'parts/headers' ); ?>

		<div class="page type-page status-publish hentry">
			<section class="row side-right gutter pad-top">
				<div class="column one">
					<h2>Announcements</h2>
					<div class="announcements-container">
						<ul class="announcements-list">

							<?php
							$wsu_alert_announcements = new WP_Query( array(
								'category_name' => 'announcements',
								'posts_per_page' => 3,
								'fields' => 'ids',
							) );

							if ( $wsu_alert_announcements->have_posts() ) {
								while ( $wsu_alert_announcements->have_posts() ) {
									$wsu_alert_announcements->the_post();
									?>
									<li class="announcement">
										<span class="announcement-item-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a></span>
										<span class="announcement-item-byline">
											<span class="announcement-item-byline-date"><?php echo esc_html( get_the_date( 'F d, Y g:ia' ) ); ?></span>
										</span>
										<span class="announcement-item-excerpt">
											<?php the_excerpt(); ?>
											<a class="announcement-item-read-story" href="<?php echo esc_url( get_the_permalink() ); ?>">Read Announcement</a>
										</span>
									</li>
									<?php
								}
							}
							wp_reset_postdata();
							?>

						</ul>
					</div>

				</div>

				<div class="column two dial-911">
					<p>To report an emergency:</p>
					<div class="dial">
						<p><img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/phone-icon.png' ); ?>" alt="phone-icon" width="47" height="47"></p>
						<h2>DIAL 9-1-1</h2>
					</div>
					<p><em>NOTE: When dialing 911 from a WSU Pullman campus number, there will be a 7 second delay in connecting. WAIT! DO NOT HANG UP</em>!</p>
				</div>

			</section>

			<?php

			the_post();
			/**
			 * `the_content` is fired on builder template pages while it is saved
			 * rather than while it is output in order for some advanced tags to
			 * survive the process and to avoid autop issues.
			 */
			remove_filter( 'the_content', 'wpautop', 10 );
			add_filter( 'wsu_content_syndicate_host_data', 'spine_filter_local_content_syndicate_item', 10, 3 );
			the_content();
			remove_filter( 'wsu_content_syndicate_host_data', 'spine_filter_local_content_syndicate_item', 10 );
			add_filter( 'the_content', 'wpautop', 10 );

			?>
		</div><!-- #post -->

		<?php get_template_part( 'parts/footers' ); ?>
	</main>
<?php

get_footer();
