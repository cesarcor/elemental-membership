<?php
namespace ElementalMembership\Widgets\Forms\Classes;

// Exit if accessed directlys
if ( ! defined( 'ABSPATH' ) ):
    exit; 
endif;

class Field_Creation{

    public function em_get_attribute_name($item){
        return "form_fields[{$item}]";
    }

    function create_input_field($field_label, $field_id, $field_type, $field_placeholder, $field_role, $is_required){

        $field_name = "";
        $field_label = strtolower(preg_replace('/\s+/', '-', $field_label));
        $field_required = $is_required ? "required" : "";

        switch($field_role):

            case "username":
                $field_name = $this->em_get_attribute_name("username");
            break;
            case "user_email":
                $field_name = $this->em_get_attribute_name("user_email");
            break;
            case "user_password":
                $field_name = $this->em_get_attribute_name("user_password");
            break;
            case "user_password_confirm":
                $field_name = $this->em_get_attribute_name("user_password_confirm");
            break;
            case "first_name":
                $field_name = $this->em_get_attribute_name("first_name");
            break;
            case "last_name":
                $field_name = $this->em_get_attribute_name("last_name");
            break;
            case "biographical_info":
                $field_name = $this->em_get_attribute_name("biographical_info");
            break;
            default:
                $field_name = $this->em_get_attribute_name("custom");
            break;

        endswitch;

        echo '<input type="'. $field_type .
        '"name="'. $field_name .'"
         id="'.$field_id.'"
         class="em-form-field em-'. $field_label .'-field" 
         placeholder="'. $field_placeholder .'" 
         em_role="'. $field_role .'"' .
         $field_required . ' />';
    }

    function create_textarea_field(){
        echo '<textarea class="em-form-field em-textarea-field"></textarea>';
    }

    function create_checkbox_field(){
        echo '<input type="checkbox" value="Checkbox!" class="em-form-field"/>';
    }

    function create_select_field($field_label, $field_options){
        $options = preg_split( "/\\r\\n|\\r|\\n/", $field_options );

        if ( ! $options ) {
			return '';
		}

        echo '<select class="em-form-field em-select-field">';

        foreach($options as $option):
            $option_label = esc_html( $option );

            echo '<option>' . $option_label . '</option>';

        endforeach;
         
        echo '</select>';
    }


}