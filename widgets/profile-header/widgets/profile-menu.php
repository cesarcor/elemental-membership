<?php

namespace ElementalMembership\Widgets\ProfileHeader;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

class Profile_Menu extends Widget_Base{

    public function get_name(){
        return 'em-profile-menu';
    }

    public function get_title(){
        return __('Profile Menu', 'elemental-membership');
    }

    public function get_icon(){
        return '';
    }

    public function get_categories(){
        return ['elemental-membership-category'];
    }

    protected function _register_controls(){

        $repeater = new Repeater();

        $this->start_controls_section(
            'em_profile_menu',
            [
                'label' => __('Menu', 'elemental-membership'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater->add_control(
            'menu_item_text',
            [
                'label' => __('Link Text', 'elemental-membership'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Item'
            ]
        );

        $repeater->add_control(
            'menu_item_url',
            [
                'label' => __('URL', 'elemental-membership'),
                'type' => \Elementor\Controls_Manager::URL
            ]
        );

        $this->add_control(
            'profile_menu_list',
            [
                'label' => __('Profile Menu', 'elemental-membership'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'menu_item_text' => __('Menu Item One', 'elemental-membership')
                    ],

                    [
                        'menu_item_text' => __('Menu Item Two', 'elemental-membership')
                    ]
                ],
                'title_field' => '{{{ menu_item_text }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'profile_menu_styles',
            [
                'label' => __('Menu', 'elemental-membership'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'profile_menu_typography',
                'label' => __('Typography', 'elemental-membership'),
                'selector' => '{{WRAPPER}} .em-profile-menu-list li a',
                'scheme' => Schemes\Typography::TYPOGRAPHY_3,
            ]
        );

        $this->start_controls_tabs( 'menu_item_color' );

        $this->start_controls_tab(
			'menu_item_color_normal',
			[
				'label' => __( 'Normal', 'elemental-membership' ),
			]
        );

        $this->add_control(
            'profile_menu_color',
            [
                'label' => __('Text Color', 'elemental-membership'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .em-profile-menu-list li a' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_3,
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
			'menu_item_color_hover',
			[
				'label' => __( 'Hover', 'elemental-membership' ),
			]
        );

        $this->add_control(
            'profile_menu_color_hover',
            [
                'label' => __('Text Color', 'elemental-membership'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .em-profile-menu-list li a:hover' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_3,
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render(){
        $settings = $this->get_settings_for_display();
    ?>

        <nav class="em-profile-menu-container">
            <ul class="em-list em-profile-menu-list">
                <?php 
                    if($settings['profile_menu_list']): 
                        foreach($settings['profile_menu_list'] as $item):
                            $target = $item['menu_item_url']['is_external'] ? ' target="_blank"' : '';
                            $nofollow = $item['menu_item_url']['nofollow'] ? ' rel="nofollow"' : '';
                            echo '<li><a href="' . $item['menu_item_url']['url'] . '"' . $target . $nofollow . '>' . $item['menu_item_text'] . '</a></li>';
                        endforeach;
                    endif; 
                ?>
            </ul>
        </nav>

    <?php
    }

    protected function _content_template(){
    ?>

        <nav class="em-profile-menu-container">
            <ul class="em-list em-profile-menu-list">
                <# if( settings.profile_menu_list.length ){ #>
                    <# _.each( settings.profile_menu_list, function(item){  #> 
                        <li><a href="#">{{{ item.menu_item_text }}}</a></li>
                <# }); } #>
            </ul>
        </nav>

    <?php
    }

}