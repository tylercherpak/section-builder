<?php

class Section_Builder {

	protected $item_count = 0;

	public static function get_section_types(){
		return array( 'hero', 'one-item', 'two-item', 'three-item', 'four-item', 'title-only-item', 'grid' );
	}

	public static function get_allowed_post_types(){
		return array( 'page' );
	}

	public function init(){
		add_action( 'init', array( $this, 'register_section_meta' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_style' ) );
	}

	public function admin_style(){
		wp_enqueue_style( 'admin-styles', get_template_directory_uri() . '/inc/section-builder/sb-admin.css' );
		wp_enqueue_script( 'admin-script', get_stylesheet_directory_uri() . '/inc/section-builder/sb-admin.js' );
	}

	public function generate_item_group( $per_group = 1 ){
		$item_group = array();
		for( $i = 0; $i < $per_group; $i++ ) {
			$item_group[ 'item-' . $this->item_count ] = new Fieldmanager_Group( array(
				'name'     => 'item-' . $this->item_count,
				'children' => array(
					'image'   => new Fieldmanager_Media( 'Image' ),
					'title'   => new Fieldmanager_TextField( 'Title' ),
					'link'    => new Fieldmanager_Link( 'URL' ),
					'excerpt' => new Fieldmanager_RichTextArea( 'Excerprt' )
				)
			) );
			$this->item_count++;
		}
		return $item_group;
	}

	public function generate_title_only_item_group( $per_group = 1 ){
		$item_group = array();
		for( $i = 0; $i < $per_group; $i++ ) {
			$item_group[ 'item-' . $this->item_count ] = new Fieldmanager_Group( array(
				'name'     => 'item-' . $this->item_count,
				'children' => array(
					'title'   => new Fieldmanager_TextField( 'Title' ),
				)
			) );
			$this->item_count++;
		}
		return $item_group;
	}

	public function register_section_meta(){
		$post_id = ! empty( $_GET['post'] ) ? intval( $_GET['post'] ) : false;
		$post_id = empty( $post_id ) && ! empty( $_POST['post_ID'] ) ? intval( $_POST['post_ID'] ) : $post_id;
		if ( empty( $post_id ) ) {
			return false;
		}

		$hero_group = new Fieldmanager_Group( array(
			'name'     => 'hero',
			'children' => $this->generate_item_group()
		) );

		$grid_group = new Fieldmanager_Group(  array(
			'name'        => 'grid',
			'sortable'    => true,
			'collapsible' => true,
			'limit'       => 0,
			'children'    => $this->generate_item_group()
		) );

		$one_item_group = new Fieldmanager_Group( array(
			'name'     => 'one-item',
			'children' => $this->generate_item_group()
		) );

		$two_item_group = new Fieldmanager_Group( array(
			'name'           => 'two-item',
			'sortable'       => true,
			'collapsible'    => true,
			'children'       => $this->generate_item_group(2)
		) );

		$three_item_group = new Fieldmanager_Group( array(
			'name'           => 'three-item',
			'sortable'       => true,
			'collapsible'    => true,
			'children'       => $this->generate_item_group(3)
		) );

		$four_item_group = new Fieldmanager_Group( array(
			'name'           => 'four-item',
			'sortable'       => true,
			'collapsible'    => true,
			'children'       => $this->generate_item_group(4)
		) );

		$title_only_item_group = new Fieldmanager_Group( array(
			'name'           => 'title-only-item',
			'sortable'       => true,
			'collapsible'    => true,
			'children'       => $this->generate_title_only_item_group()
		) );

		$section_type = new Fieldmanager_Radios( 'Section Type', array(
			'name'    => 'section-type',
			'default_value' => 'hero',
			'options' => self::get_section_types()
		) );

		$fm = new Fieldmanager_Group( array(
			'name'           => 'sections',
			'limit'          => 0,
			'sortable'       => true,
			'children'       => array(
				'section' => new Fieldmanager_Group( array(
					'name'           => 'section',
					'label'          => 'section',
					'collapsible'    => true,
					'add_more_label' => 'Add another section',
					'children'       => array(
						'section-type'    => $section_type,
						'hero'            => $hero_group,
						'one-item'        => $one_item_group,
						'two-item'        => $two_item_group,
						'three-item'      => $three_item_group,
						'four-item'       => $four_item_group,
						'title-only-item' => $title_only_item_group,
						'grid'            => $grid_group
			) ) )
		) ) );

		$fm->add_meta_box( 'Section Builder', self::get_allowed_post_types() );

	}
}

$section_builder = new Section_Builder();
$section_builder->init();