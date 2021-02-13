<article <?php echo $settings_output['article_attr']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<figure class="image-card card">
		<?php echo $settings_output['thumbnail']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

		<figcaption>
			<div class="card__content">
				<header>
					<?php if ( 'mp_static_posts' !== $this->get_name() && 'yes' === $settings['show_metadata'] && in_array( 'category', $settings['metadata_content'], true ) ) : ?>
						<div class="category-badge mb-3">
							<?php the_terms( $post->ID, $settings_output['terms_id'], '', ' ' ); ?>
						</div>
					<?php endif; ?>

					<?php if ( 'yes' === $settings['show_title'] ) : ?>
						<a href="<?php echo $settings_output['permalink']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" <?php echo esc_attr( $settings_output['permalink_target'] ) . esc_attr( $settings_output['permalink_nofollow'] ); ?>>
							<<?php echo $settings_output['html_tag']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="card__title"><?php echo esc_html( $settings_output['title'] ); ?></<?php echo $settings_output['html_tag']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						</a>
					<?php endif; ?>


					<?php if ( 'mp_static_posts' !== $this->get_name() && 'yes' === $settings['show_metadata'] ) : ?>
						<div class="card__data d-inline-flex align-items-center flex-wrap">
							<?php if ( 'yes' === $settings['show_metadata'] && in_array( 'author', $settings['metadata_content'], true ) ) : ?>
								<div class="card__author-meta">
									<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
										<?php echo get_avatar( get_the_author_meta( 'user_email' ), '35' ); ?>
										<span class="mr-2"><?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?></span>
									</a>
								</div>
								<?php
							endif;
							if ( 'yes' === $settings['show_metadata'] && in_array( 'date', $settings['metadata_content'], true ) ) :
								?>
								<div class="d-flex align-items-center card__meta mr-3">
									<span class="flaticon-clock ml-2 mt-0"></span>
									<span>
										<?php
										global $mihanpress_options;
										'human_time' === $mihanpress_options['blog_single_date_type'] ? printf( _x( '%s پیش', '%s = مدت زمان گذشته از ارسال نوشته', 'mihanpress' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ) : printf( get_the_date() );
										?>
									</span>
								</div>
								<?php
							endif;
							if ( 'yes' === $settings['show_metadata'] && in_array( 'comments', $settings['metadata_content'], true ) ) :
								?>
								<div class="d-flex align-items-center card__meta mr-3">
									<span class="flaticon-speech-bubble ml-2"></span>
									<span><?php echo sprintf( esc_html__( '%s نظر', 'mihanpress-elmentor-addons' ), get_comments_number() ); ?></span>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</header>

			</div>
		</figcaption>
	</figure>
</article>
