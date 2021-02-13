<article <?php echo $settings_output['article_attr']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="card d-flex flex-column <?php echo esc_attr( $settings_output['modern_thumbnail'] ); ?>">

		<?php if ( 'yes' === $settings['show_thumbnail'] ) : ?>
			<a href="<?php echo $settings_output['permalink']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" <?php echo esc_attr( $settings_output['permalink_target'] ) . esc_attr( $settings_output['permalink_nofollow'] ); ?>>
				<figure class="card__thumbnail position-relative">
					<?php echo $settings_output['thumbnail']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

					<?php if ( 'yes' === $settings['show_thumbnail_overlay'] ) : ?>
						<figcaption class="card-thumbnail_overlay"></figcaption>
					<?php endif; ?>
				</figure>
			</a>
		<?php endif; ?>

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
				<?php
				if ( 'mp_static_posts' !== $this->get_name() && 'yes' === $settings['show_price'] && class_exists( 'WooCommerce' ) ) {
					echo '<div class="mt-3 mb-3">';
					wc_get_template( 'loop/price.php' );
					echo '</div>';
				} elseif ( 'mp_static_posts' === $this->get_name() && $post_item['after_title'] ) {
					echo '<span class="card-data__text text-success d-block mt-3 mb-3">' . esc_html( $post_item['after_title'] ) . '</span>';
				}

				if ( 'mp_static_posts' !== $this->get_name() && 'yes' === $settings['show_modified'] ) {
					echo '<div class="card__modified-date btn-success">' . human_time_diff( get_the_modified_date( 'U' ), current_time( 'timestamp' ) ) . ' پیش </div>';
				}
				?>

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
			<?php if ( 'yes' === $settings['show_excerpt'] ) : ?>
				<div class="card-excerpt pl-3 pr-3 mt-3">
					<?php echo wp_kses_post( $settings_output['excerpt'] ); ?>
				</div>
				<?php
			endif;
			if ( 'yes' === $settings['show_read_more'] ) :
				?>
				<a href="<?php echo esc_url( $settings_output['permalink'] ); ?>" <?php echo esc_attr( $settings_output['permalink_target'] ) . esc_attr( $settings_output['permalink_nofollow'] ); ?> class="btn position-relative d-inline-block mt-4 pr-5 pl-5 <?php echo esc_attr( $settings_output['button_class'] ); ?>"><?php echo esc_html( $settings['read_more_text'] ); ?></a>
			<?php endif; ?>
		</div>

	</div>
</article>
