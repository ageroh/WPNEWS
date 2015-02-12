<?php
/*
 *  Setup main navigation menu
 */
add_action( 'init', 'register_my_menu' );
function register_my_menu() {
	register_nav_menu( 'second-menu', __( 'Main Menu', THEMEDOMAIN ) );
	register_nav_menu( 'footer-menu', __( 'Footer Menu', THEMEDOMAIN ) );
}

//Add custom background
add_theme_support( 'automatic-feed-links' );

/*
 *  Setup mega menu option
 */
add_action( 'init', array( 'TG_Nav_Menu_Item_Custom_Fields', 'setup' ) );

class TG_Nav_Menu_Item_Custom_Fields {
	static $options = array();

	static function setup() {
		//Get current custom sidebars
		$current_sidebars = get_option(SHORTNAME."_sidebar");
		$mega_menu_area_arr = array();
		
		if(!empty($current_sidebars))
		{
			foreach($current_sidebars as $sidebar)
			{
				$mega_menu_area_arr[$sidebar] = $sidebar;
			}
		}
	
		self::$options['fields'] = array(
			'mega_menu' => array(
				'name' => 'mega_menu',
				'label' => __('Use Mega Menu', THEMEDOMAIN),
				'container_class' => '',
				'input_type' => 'checkbox',
			),
			'mega_menu_sidebar' => array(
				'name' => 'mega_menu_sidebar',
				'label' => __('Display Widget Area', THEMEDOMAIN),
				'container_class' => '',
				'input_type' => 'select',
				'options' => $mega_menu_area_arr,
			),
		);

		add_filter( 'TG_nav_menu_item_additional_fields', array( __CLASS__, '_add_fields' ), 10, 5 );
		add_action( 'save_post', array( __CLASS__, '_save_post' ) );
	}

	static function get_fields_schema() {
		$schema = array();
		foreach(self::$options['fields'] as $name => $field) {
			if (empty($field['name'])) {
				$field['name'] = $name;
			}
			$schema[] = $field;
		}
		return $schema;
	}

	static function get_menu_item_postmeta_key($name) {
		return 'pp_menu_item_' . $name;
	}

	/**
	 * Inject the 
	 * @hook {action} save_post
	 */
	static function _add_fields($new_fields, $item_output, $item, $depth, $args) {
		$schema = self::get_fields_schema($item->ID);
		$new_fields = '';
		foreach($schema as $field) {
			$field['value'] = get_post_meta($item->ID, self::get_menu_item_postmeta_key($field['name']), true);
			
			$field['id'] = $item->ID;
			
			switch($field['input_type'])
			{
				case 'checkbox':
					$new_fields.= '<p class="additional-menu-field-'.$field['name'].' description description-thin">';
					$new_fields.= '<input type="checkbox" id="edit-menu-item-'.$field['name'].'-'.$field['id'].'" class="edit-menu-item-'.$field['name'].'" name="menu-item-'.$field['name'].'['.$field['id'].']" value="1"';
					
					if(!empty($field['value']))
					{
						$new_fields.= 'checked';
					}
					
					$new_fields.= '>&nbsp;';
					$new_fields.= '<label for="edit-menu-item-'.$field['name'].'-'.$field['id'].'">'.$field['label'].'</label></p>';
				break;
				case 'select':
					$new_fields.= '<p class="additional-menu-field-'.$field['name'].' description description-thin">';
					$new_fields.= '<label for="edit-menu-item-'.$field['name'].'-'.$field['id'].'">'.$field['label'].'</label><br/>';
					$new_fields.= '<select id="edit-menu-item-'.$field['name'].'-'.$field['id'].'" class="edit-menu-item-'.$field['name'].'" name="menu-item-'.$field['name'].'['.$field['id'].']">';
					if(!empty($field['options']))
					{
						foreach($field['options'] as $option)
						{
							$new_fields.= '<option value="'.$option.'" ';
							
							if($option==$field['value'])
							{
								$new_fields.= 'selected';
							}
							
							$new_fields.= '>'.$option.'</option>';
						}
					}
					
					$new_fields.= '</select></p>';
				break;
			}			
		}
		return $new_fields;
	}

	/**
	 * Save the newly submitted fields
	 * @hook {action} save_post
	 */
	static function _save_post($post_id) {
		if (get_post_type($post_id) !== 'nav_menu_item') {
			return;
		}
		$fields_schema = self::get_fields_schema($post_id);
		foreach($fields_schema as $field_schema) {
			$form_field_name = 'menu-item-' . $field_schema['name'];
			if (isset($_POST[$form_field_name][$post_id])) {
				$key = self::get_menu_item_postmeta_key($field_schema['name']);
				$value = stripslashes($_POST[$form_field_name][$post_id]);
				update_post_meta($post_id, $key, $value);
			}
			else
			{
				$key = self::get_menu_item_postmeta_key($field_schema['name']);
				update_post_meta($post_id, $key, '');
			}
		}
	}

}

add_filter( 'wp_edit_nav_menu_walker', 'custom_nav_edit_walker',10,2 );
function custom_nav_edit_walker($walker,$menu_id) {
    return 'TG_Walker_Nav_Menu_Edit';
}

require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
class TG_Walker_Nav_Menu_Edit extends Walker_Nav_Menu_Edit {
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		$item_output = '';
		parent::start_el($item_output, $item, $depth, $args);
		$new_fields = apply_filters( 'TG_nav_menu_item_additional_fields', '', $item_output, $item, $depth, $args );

		if ($new_fields) {
			$item_output = preg_replace('/(?=<div[^>]+class="[^"]*submitbox)/', $new_fields, $item_output);
		}
		$output .= $item_output;
	}
}

if(!function_exists('get_dynamic_sidebar'))
{
	function get_dynamic_sidebar($index = 1)
	{
		$sidebar_contents = "";
		ob_start();
		dynamic_sidebar($index);
		$sidebar_contents = ob_get_clean();
		return $sidebar_contents;
	}
}

class tg_walker extends Walker_Nav_Menu {

	//start of the sub menu wrap
	function start_lvl(&$output, $depth = 0, $args = array()) {
		$output .= '<ul class="sub-menu">';
	}
 
	//end of the sub menu wrap
	function end_lvl(&$output, $depth = 0, $args = array()) {
		$output .= '
					</ul>';
	}
 
	//add the description to the menu item output
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $wp_query;
		
		//Check if use Mega Menu Option
		$obj_tg_nav = new TG_Nav_Menu_Item_Custom_Fields();
		$use_mega_menu = get_post_meta($item->ID, $obj_tg_nav->get_menu_item_postmeta_key('mega_menu'), true);
		
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
 
		$class_names = $value = '';
 
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
 
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names );
		if(!empty($use_mega_menu))
		{
			$class_names.= ' arrow';
		}
		$class_names .= '"';
 
		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
 
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes.= ! empty( $item->target )	 ? ' target="' . esc_attr( $item->target	 ) .'"' : '';
		$attributes.= ! empty( $item->xfn )		? ' rel="'	. esc_attr( $item->xfn		) .'"' : '';
		$attributes.= ! empty( $item->url )		? ' href="'   . esc_attr( $item->url		) .'"' : '';
		
		$item_output = $args->before;
		$item_output.= '<a'. $attributes .'>';
		$item_output.= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output.= '</a>';
		
		if(!empty($use_mega_menu))
		{
			$mega_menu_sidebar = get_post_meta($item->ID, $obj_tg_nav->get_menu_item_postmeta_key('mega_menu_sidebar'), true);
			$item_output.= '<div class="mega_menu_wrapper"><div class="mega_menu_bg"><ul class="sidebar_widget">'.get_dynamic_sidebar($mega_menu_sidebar).'</ul><br class="clear"/></div></div>';
		}
		
		$item_output.= $args->after;
 
		$output.= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	
	function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {
        $id_field = $this->db_fields['id'];
        if (!empty($children_elements[$element->$id_field])) { 
            $element->classes[] = 'arrow'; //enter any classname you like here!
        }
        Walker_Nav_Menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}

?>