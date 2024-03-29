<?php

namespace ElementalMembership\Widgets\Forms;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Plugin;
use ElementalMembership\Widgets\Forms\Classes\Field_Creation;
use ElementalMembership\Widgets\Forms\Classes\Form_Message;
use ElementalMembership\Widgets\Forms\Traits\Register_User;

// Exit if accessed directly
if (!defined('ABSPATH')){
     exit;
}

class Registration_Form extends Widget_Base {
    use Register_User;

    protected $page_id;

    public function get_name() {
        return 'em-registration-form';
    }

    public function get_title() {
        return __('User Registration Form', 'elemental-membership');
    }

    public function get_icon() {
        return 'icon-em-user-registration';
    }

    public function get_categories() {
        return ['elemental-membership-category'];
    }

    protected function register_controls() {
        $repeater = new Repeater();

        $em_field_widths = [
            '' => __('Default', 'elemental-membership'),
            '100' => '100%',
            '80' => '80%',
            '75' => '75%',
            '66' => '66%',
            '60' => '60%',
            '50' => '50%',
            '40' => '40%',
            '33' => '33%',
            '25' => '25%',
            '20' => '20%',
        ];

        $em_field_type = [
            'username' => __('Username', 'elemental-memebership'),
            'user_email' => __('User Email', 'elemental-memebership'),
            'user_password' => __('User Password', 'elemental-memebership'),
            'user_password_confirm' => __('Password Confirmation', 'elemental-memebership'),
            'first_name' => __('First Name', 'elemental-membership'),
            'last_name' => __('Last Name', 'elemental-membership'),
            'user_description' => __('User Description', 'elemental-membership')
        ];

        $em_user_roles = [
            'subscriber' => __('Subscriber', 'elemental-membership'),
            'contributor' => __('Contributor', 'elemental-membership'),
            'author' => __('Author', 'elemental-membership'),
            'editor' => __('Editor', 'elemental-membership'),
            'administrator' => __('Administrator', 'elemental-membership'),
        ];

        $this->start_controls_section(
            'em_fields_section',
            [
                'label' => __('Fields', 'elemental-membership'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control( 
            'form_fields_notice', 
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => __( 'Note: Please avoid adding multiple fields of the same type', 'elemental-membership' ),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
		    ] 
        );

        $repeater->add_control(
            'em_field_type',
            [
                'label' => __('Field Type', 'elemental-membership'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'first_name',
                'options' => $em_field_type
            ]
        );

        $repeater->add_control(
            'em_field_label',
            [
                'label' => __('Field Label', 'elemental-membership'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => ''
            ]
        );

        $repeater->add_control(
            'em_field_placeholder',
            [
                'label' => __('Field Placeholder', 'elemental-membership'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => ''
            ]
        );

        $repeater->add_control(
            'em_field_required',
            [
                'label' => __('Required', 'elemental-membership'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'condition' => [
                    'em_field_type!' => ['username', 'user_email', 'user_password', 'user_password_confirm']
                ],
                'default' => ''
            ]
        );

        $repeater->add_control(
            'em_field_width',
            [
                'label' => __('Field Width', 'elemental-membership'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '100',
                'options' => $em_field_widths
            ]
        );

        $this->add_control(
            'em_field_list',
            [
                'label' => __('Field List', 'elemental-membership'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'em_field_label' => __('Username', 'elemental-membership'),
                        'em_field_placeholder' => 'jondoe',
                        'em_field_required' => 'true',
                        'em_field_type' => 'username'
                    ],

                    [
                        'em_field_label' => __('Your Email', 'elemental-membership'),
                        'em_field_placeholder' => 'jondoe@mail.com',
                        'em_field_required' => 'true',
                        'em_field_type' => 'user_email'
                    ],

                    [
                        'em_field_label' => __('Password', 'elemental-membership'),
                        'em_field_placeholder' => __('Type password', 'elemental-membership'),
                        'em_field_required' => 'true',
                        'em_field_type' => 'user_password'
                    ],

                    [
                        'em_field_label' => __('Confirm Password', 'elemental-membership'),
                        'em_field_placeholder' => __('Type password again', 'elemental-membership'),
                        'em_field_required' => 'true',
                        'em_field_type' => 'user_password_confirm'
                    ]
                ],

                'title_field' => '{{{ em_field_label }}}',
            ]
        );

        $this->add_control(
            'show_labels',
            [
                'label' => __('Label', 'elemental-membership'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'elemental-membership'),
                'label_off' => __('Hide', 'elemental-membership'),
                'return_value' => 'true',
                'default' => 'true',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'em_registration_options_section',
            [
                'label' => __('Registration Options', 'elemental-membership'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'em_user_role',
            [
                'label' => __('User Role', 'elemental-membership'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'subscriber',
                'options' => $em_user_roles
            ]
        );

        $this->add_control(
            'user_requires_approval',
            [
                'label' => __('User Requires Approval', 'elemental-membership'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'elemental-membership'),
                'label_off' => __('No', 'elemental-membership'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        
		$this->add_control(
			'em_registration_actions',
			[
				'label' => __( 'Registration Actions', 'elemental-membership' ),
                'label_block' => true,
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
                'separator' => 'before',
				'options' => [
					'auto_login'  => __( 'Auto Login', 'elemental-membership' ),
					'email_notification' => __( 'Send Notification Email', 'elemental-membership' ),
				],
				'default' => [ 'auto_login' ],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'em_submit_button_section',
            [
                'label' => __('Submit Button', 'elemental-membership'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'em_submit_button_text',
            [
                'label' => __('Button Text', 'elemental-membership'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Register',
                'placeholder' => ''
            ]
        );

        $this->add_responsive_control(
            'em_button_width',
            [
                'label' => __('Column Width', 'elemental-membership'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '100',
                'options' => $em_field_widths,
            ]
        );

        $this->add_responsive_control(
            'em_button_align',
            [
                'label' => __('Alignment', 'elemental-membership'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => __('Left', 'elemental-membership'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'elemental-membership'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'end' => [
                        'title' => __('Right', 'elemental-membership'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'stretch' => [
                        'title' => __('Justified', 'elemental-membership'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => 'start',
                'prefix_class' => 'elementor%s-button-align-',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'em_user_registered_section',
            [
                'label' => __('User Already Registered', 'elemental-membership'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'registration_form_view',
            [
                'label' => __('View As', 'elemental-membership'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'not_registered_view' => 'User not registered',
                    'is_registered_view' => 'Already Registered'
                ],
                'default' => 'not_registered_view',
            ]
        );

        $this->add_control(
            'already_registered_message',
            [
                'label' => __('Already Registered Text', 'elemental-membership'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 5,
                'default' => __('You are already registered', 'elemental-membership')
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'regform_terms_and_conditions_section',
            [
                'label' => __('Terms & Conditions', 'elemental-membership'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_tnc',
            [
                'label' => __('Impose Terms & Conditions', 'elemental-membership'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'elemental-membership'),
                'label_off' => __('Hide', 'elemental-membership'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'tnc_text',
            [
                'label' => __('Terms & Conditions Text', 'elemental-membership'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => __('I accept', 'elemental-membership'),
                'default' => __('I Accept', 'elemental-membership'),
                'condition' => [
                    'show_tnc' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'tnc_text_link',
            [
                'label' => __('Terms & Conditions Text Link', 'elemental-membership'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => __('the terms & conditions', 'elemental-membership'),
                'default' => __('the terms & conditions', 'elemental-membership'),
                'condition' => [
                    'show_tnc' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'tnc_link',
            [
                'label' => __('Terms & Conditions Link', 'elemental-membership'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true
                ],
                'condition' => [
                    'show_tnc' => 'yes'
                ],
                'default' => [
                    'url' => get_the_permalink(get_option('wp_page_for_privacy_policy')),
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'validation_messages',
            [
                'label' => __('Validation Messages', 'elemental-membership'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'vm_password_confirm',
			[
				'label' => __( 'Password confirmation not passed', 'elemental-membership' ),
                'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Password confirmation does not match', 'elemental-membership' ),
			]
		);

        $this->add_control(
			'vm_tnc_acceptance',
			[
				'label' => __( 'Terms & Conditions not accepted', 'elemental-membership' ),
                'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'To create an account, please accept our terms & conditions', 'elemental-membership' ),
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'em_registration_form_style',
            [
                'label' => __('Registration Form Styles', 'elemental-membership'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'column_gap',
            [
                'label' => __('Columns Gap', 'elemental-membership'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-field-group' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
                    '{{WRAPPER}} .elementor-form-fields-wrapper' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
                ],
            ]
        );

        $this->add_control(
            'em_row_gap',
            [
                'label' => __('Rows Gap', 'elemental-membership'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .em-form-field-group' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_label',
            [
                'label' => __('Label', 'elemental-membership'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'label_spacing',
            [
                'label' => __('Spacing', 'elemental-membership'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    'body.rtl {{WRAPPER}} .elementor-labels-inline .elementor-field-group > label' => 'padding-left: {{SIZE}}{{UNIT}};',
                    // for the label position = inline option
                    'body:not(.rtl) {{WRAPPER}} .elementor-labels-inline .elementor-field-group > label' => 'padding-right: {{SIZE}}{{UNIT}};',
                    // for the label position = inline option
                    'body {{WRAPPER}} .elementor-labels-above .elementor-field-group > label' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                    // for the label position = above option
                ],
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => __('Text Color', 'elemental-membership'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-field-group > label, {{WRAPPER}} .elementor-field-subgroup label' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_3,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .elementor-field-group > label',
                'scheme' => Schemes\Typography::TYPOGRAPHY_3,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'em_registration_form_field_style',
            [
                'label' => __('Fields', 'elemental-membership'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'field_text_color',
            [
                'label' => __('Text Color', 'elemental-membership'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .em-form-field-group .em-form-field' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_3,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'field_typography',
                'selector' => '{{WRAPPER}} .em-form-field-group .em-form-field, {{WRAPPER}} .em-form-field-group label',
                'scheme' => Schemes\Typography::TYPOGRAPHY_3,
            ]
        );

        $this->add_control(
            'field_background_color',
            [
                'label' => __('Background Color', 'elemental-membership'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .em-form-field' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'field_border_color',
            [
                'label' => __('Border Color', 'elemental-membership'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .em-form-field-group .em-form-field' => 'border-color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'field_border_width',
            [
                'label' => __('Border Width', 'elemental-membership'),
                'type' => Controls_Manager::DIMENSIONS,
                'placeholder' => '1',
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .em-form-field-group .em-form-field' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'field_border_radius',
            [
                'label' => __('Border Radius', 'elemental-membership'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .em-form-field-group .em-form-field' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'em_registration_form_button_style',
            [
                'label' => __('Button', 'elemental-membership'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __('Normal', 'elemental-membership'),
            ]
        );

        $this->add_control(
            'em_button_background_color',
            [
                'label' => __('Background Color', 'elemental-membership'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .em-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'em_button_text_color',
            [
                'label' => __('Text Color', 'elemental-membership'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .em-button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .em-button svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'em_button_typography',
                'scheme' => Schemes\Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .em-button',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .em-button',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => __('Border Radius', 'elemental-membership'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .em-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_text_padding',
            [
                'label' => __('Text Padding', 'elemental-membership'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .em-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __('Hover', 'elemental-membership'),
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label' => __('Background Color', 'elemental-membership'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .em-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => __('Text Color', 'elemental-membership'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .em-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'em_tnc_styles',
            [
                'label' => __('Terms & Conditions', 'elemental-membership'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tnc_typography',
                'selector' => '{{WRAPPER}} .em-tnc-wrap > *',
                'scheme' => Schemes\Typography::TYPOGRAPHY_3,
            ]
        );

        $this->add_control(
            'tnc_text_color',
            [
                'label' => __('Text Color', 'elemental-membership'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .em-tnc-text' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_3,
                ],
            ]
        );

        $this->add_control(
            'tnc_link_color',
            [
                'label' => __('Link Color', 'elemental-membership'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .em-tnc-link' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_3,
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'validation_styles',
            [
                'label' => __('Validation Messages', 'elemental-membership'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'error_message_color',
            [
                'label' => __('Validation Errors', 'elemental-membership'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .em-form-error' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_3,
                ],
                'default' => '#ed2828'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'error_message_typography',
                'selector' => '{{WRAPPER}} .em-form-error',
                'scheme' => Schemes\Typography::TYPOGRAPHY_3,
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ((is_user_logged_in() &&
             !\Elementor\Plugin::$instance->editor->is_edit_mode()) ||
             (is_user_logged_in() &&
             $settings['registration_form_view'] == 'is_registered_view')
             ){ ?>

            <div class="em-user-registered-msg">
                <?php echo esc_html($settings['already_registered_message']); ?>
            </div>

         <?php
        } else{
    
         $this->render_form();
         
        } 

    }

    /**
     *
     * Renders user registration form on the front-end
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render_form(){
        
        $settings = $this->get_settings_for_display();
        $buttonWidth = (('' !== $settings['em_button_width']) ? $settings['em_button_width'] : '100');
        $input_type = '';

        if (Plugin::$instance->documents->get_current()){
            $this->page_id = Plugin::$instance->documents->get_current()->get_main_id();
        }
        ?>

        <form class="em-user-registration-form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>" enctype="multipart/form-data">

        <div class="elementor-form-fields-wrapper elementor-labels-above">

            <?php $this->render_fields(); ?>

            <?php if ('yes' === $settings['show_tnc']){ ?>
                <div class="em-form-field-group elementor-field-group">
                    <?php $this->display_terms_and_conditions(); ?>
                </div>
            <?php } ?>

            <div class="elementor-field-group elementor-column elementor-col-<?php echo esc_attr($buttonWidth); ?>">
                <button type="submit" name="em-register-user" class="em-button elementor-button em-submit-button">
                    <span><?php echo esc_html($settings['em_submit_button_text']); ?></span>
                </button>
            </div>

            <div class="elementor-field-group">
                <div class="em-form-error"></div>
                <div class="em-form-success"></div>
            </div>

        </div>

        <input type="hidden" name="action" value="em_register_user" />
        <?php wp_nonce_field('em_register_user', 'em_register_user_nonce'); ?>
        <input type="hidden" name="page_id" value="<?php echo esc_attr($this->page_id); ?>">
        <input type="hidden" name="widget_id" value="<?php echo esc_attr($this->get_id()); ?>">

    </form>

    <?php
        
    }

    protected function render_fields(){
        $settings = $this->get_settings_for_display();
        $field_creation = new Field_Creation();

        $username_exists = 0;
        $first_name_exists = 0;
		$last_name_exists = 0;
        $user_email_exists = 0;
		$user_password_exists = 0;
		$user_password_confirm_exists = 0;
		$user_description_exists = 0;

        $em_field_type = [
            'username' => __('Username', 'elemental-memebership'),
            'user_email' => __('User Email', 'elemental-memebership'),
            'user_password' => __('User Password', 'elemental-memebership'),
            'user_password_confirm' => __('Password Confirmation', 'elemental-memebership'),
            'first_name' => __('First Name', 'elemental-membership'),
            'last_name' => __('Last Name', 'elemental-membership'),
            'user_description' => __('User Description', 'elemental-membership')
        ];
        $repeated_fields = array();
        $required_fields = array();

        foreach ($settings['em_field_list'] as $item_index => $item){

                $fieldWidth = (('' !== $item['em_field_width']) ? $item['em_field_width'] : '100'); 
    
                $field_type = $item['em_field_type'];
                $dynamic_field_name = "{$field_type}_exists";
                $$dynamic_field_name ++;
    
                if ( $$dynamic_field_name > 1 ){
                    $repeated_fields[] = $em_field_type[ $field_type ];
                }
                
        ?>
    
            <div class="em-user-registration-form__field em-form-field-group elementor-field-group elementor-column elementor-col-<?php echo esc_attr($fieldWidth); ?>">
    
            <?php
                if ($settings['show_labels']){
                    echo('<label for="' . esc_attr($item['em_field_label']) . '">' . esc_attr($item['em_field_label']) . '</label>');
                }
    
                switch ($item['em_field_type']){
                            case 'username':
                            case 'first_name':
                            case 'last_name':
                                $field_creation->create_input_field(
                                    $item['em_field_label'],
                                    $item['em_field_label'],
                                    'text',
                                    $item['em_field_placeholder'],
                                    $item['em_field_type'],
                                    $item['em_field_required']
                                );
                break;
                case 'user_password':
                case 'user_password_confirm':
    
                                $password_field_role = ($item['em_field_type'] == 'user_password') ? 'user_password' : 'user_password_confirm';
    
                $field_creation->create_input_field(
                    $item['em_field_label'],
                    $item['em_field_label'],
                    'password',
                    $item['em_field_placeholder'],
                    $password_field_role,
                    $item['em_field_required']
                );
    
                break;
                case 'user_email':
                        $field_creation->create_input_field(
                            $item['em_field_label'],
                            $item['em_field_label'],
                            'email',
                            $item['em_field_placeholder'],
                            $item['em_field_type'],
                            $item['em_field_required']
                        );
                break;
                case 'user_description':
                        $field_creation->create_textarea_field();
                break;
                case 'checkbox':
                        $field_creation->create_checkbox_field();
                break;
                case 'select':
                        $field_creation->create_select_field($item['em_field_label'], $item['em_field_options']);
                break;
                } 
            ?>
    
            </div>
    
            <?php } ?>

            <?php
                if($username_exists === 0){
                    $required_fields[] = $em_field_type[ 'username' ];
                }

                if($user_email_exists === 0){
                    $required_fields[] = $em_field_type[ 'user_email' ];
                }

                if($user_password_exists === 0){
                    $required_fields[] = $em_field_type[ 'user_password' ];
                }
            ?>

            <?php
                if(\Elementor\Plugin::$instance->editor->is_edit_mode()){
                    $repeated_field = $this->display_repeated_fields_error($repeated_fields);
                    $required_field = $this->display_required_fields_error($required_fields);
                    
                    if($repeated_field || $required_field){
                        return;
                    }
                }
            ?>

    <?php        
    }

    /**
     *
     * Shows acceptance field
     *
     * @since 1.0.0
     * @access public
     */
    protected function display_terms_and_conditions() {
        $settings = $this->get_settings_for_display(); ?>
        <div class = "em-tnc-wrap">
            <input type="checkbox" name="form_fields[accept_tnc]" id="em-tnc-acceptance" class="em-tnc-text" value="yes" />
            <label for="em-tnc-acceptance"><?php echo esc_html($settings['tnc_text']); ?></label>
            <a href="<?php echo esc_url($settings['tnc_link']['url']); ?>" class="em-tnc-link"><?php echo esc_html($settings['tnc_text_link']); ?></a>
        </div>

    <?php
    }

    protected function display_repeated_fields_error($repeated_fields){
        if ( ! empty( $repeated_fields ) ){
			$error_fields = '<strong>' . implode( "</strong>, <strong>", $repeated_fields ) . '</strong>';
			?>
            <div class='elementor-field-group'>
                <p class='em-repeated-f-error elementor-alert elementor-alert-warning'>
                    <?php
                    /* translators: %s: Error fields */
                    printf( __( '<b>Error!</b> you have added the %s field type more than once', 'elemental-membership' ), $error_fields );
                    ?>
                </p>
            </div>
			<?php
			return true;
		}

		return;
    }

    protected function display_required_fields_error($missing_fields){
        if ( ! empty( $missing_fields ) ){
			$error_fields = '<strong>' . implode( "</strong>, <strong>", $missing_fields ) . '</strong>';
			?>
            <div class='elementor-field-group'>
                <p class='em-repeated-f-error elementor-alert elementor-alert-warning'>
                    <?php
                    /* translators: %s: Error fields */
                    printf( __( '<b>Error!</b> the %s field type(s) is required', 'elemental-membership' ), $error_fields );
                    ?>
                </p>
            </div>
			<?php
			return true;
		}

		return;
    }

}
