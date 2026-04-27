<?php
global $sections;
if ( '' != $sections && "none" != $sections[0]['_ttm_section_layout'] ):
	foreach ( $sections as $section ):
		$section_layout = array_key_exists( '_ttm_section_layout', $section ) && '' != $section['_ttm_section_layout'] ? $section['_ttm_section_layout'] : '';
		$section_bg = array_key_exists( '_ttm_section_bg', $section ) && '' != $section['_ttm_section_bg'] ? 'imagebg' : '';
		$section_class = array_key_exists( '_ttm_section_class', $section ) && '' != $section['_ttm_section_class'] ? $section['_ttm_section_class'] : '';
		?>
		<div class="section <?php echo $section_layout . ' ' . $section_bg . ' ' . $section_class; ?>"
			<?php echo ( array_key_exists( '_ttm_section_bg', $section ) && '' != $section['_ttm_section_bg'] ) ? 'style="background-image: url(' . $section['_ttm_section_bg'] . ')"' : ''; ?>>
			<div class="holder">
				<?php if ( array_key_exists( '_ttm_section_img', $section ) && 'imagebg' != $section['_ttm_section_layout'] && '' != $section['_ttm_section_img'] ): ?>
					<div class="img-container image-container">
						<?php echo wp_get_attachment_image( $section['_ttm_section_img_id'], 'full' ); ?>
					</div>
				<?php endif; ?>

				<div class="detail">
					<?php echo ( array_key_exists( '_ttm_section_content', $section ) && '' != $section['_ttm_section_content'] ) ? apply_filters( 'the_content', $section['_ttm_section_content'] ) : ''; ?>
				</div>
			</div>
		</div> <!-- section ends -->
		<?php
	endforeach;
endif; ?>