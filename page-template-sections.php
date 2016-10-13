<?php

/* Template Name: Section Builder */

get_header();

while( have_posts() ) :  the_post();
	$meta = get_post_meta(get_the_ID(), 'sections', true );
	foreach( $meta as $sections ){
		foreach( $sections as $section ){
			if( empty( $section['section-type'] ) ){
				continue;
			}
			$section_type = $section['section-type'];
			printf( '<div class=%s>', esc_attr( $section_type ) );
			foreach( $section[$section_type] as $item ){
				$image_id = ! empty( $item['image'] ) ? $item['image'] : '';
				$image_output = '';
				if( ! empty( $image_id ) ){
					$image_output = wp_get_attachment_image( $image_id );
				}
				$title   = ! empty( $item['title'] ) ? $item['title'] : '';
				$excerpt = ! empty( $item['excerpt'] ) ? $item['excerpt'] : '';
				$link    = ! empty( $item['link'] ) ? $item['link'] : '';
				$item_output  = sprintf( '<a href="%s"><h3>%s</h3></a>', esc_url( $link ), esc_html( $title ) );
				$item_output .=  sprintf( '<a href="%s">%s</a>', esc_url( $link ), wp_kses_post( $image_output ) );
				$item_output .=  sprintf( '<div class="excerpt">%s</div>', wp_kses_post( $excerpt ) );
				$single_item_classes = $section_type . ' single-item';
				printf('<div class="%s">%s</div>', esc_attr( $single_item_class ), wp_kses_post( $item_output ) );
			}
			printf( '</div>' ); //end section type div
		}
	}
endwhile;

get_footer();