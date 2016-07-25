<?php
	/**
	 * Convert array of attribute to string of key='value' pair
	 * 
	 * @param  array $arr_data 		array of attributes
	 * @return string           	ready to use html attributes string
	 */
	function ss_print_attributes($arr_data){
		$str_data = "";
        foreach ($arr_data as $key => $value) {
        	$str_data .= $key."='".$value."'";
        }
        return $str_data;
	}

	/**
	 * Check is widget created by ss base on widget id_base
	 *
	 * @param  string  $widget_id_base
	 * @return boolean
	 * @author heryno
	 */
	function is_ss_widget($widget_id_base){
		$arr_ss_widget = array(
							'ss_logo_widget', 
							'ss_menu_widget', 
							'ss_page_widget', 
							'ss_current_page_widget', 
							'ss_parent_child_links_widget', 
							'ss_part_widget',
							'ss_container_open_widget',
							'ss_container_close_widget',
							'ss_parts_accordion_widget',
							'ss_parts_slider_widget',
							'ss_parts_widget',
							'ss_ypnz_footer_widget'
						);

		if(in_array($widget_id_base, $arr_ss_widget)){
			return true;
		}

		return false;
	}


	function ss_get_next_widget_index($widget_id_base){
		$widget = get_option("widget_".$widget_id_base, true);
		$highest_index = max(array_keys($widget));
		$highest_index = max(count($widget),$highest_index);
	}

?>