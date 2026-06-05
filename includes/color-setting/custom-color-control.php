<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

  $urbantaxi_theme_custom_setting_css = '';

    // Global Color
    $urbantaxi_first_theme_color = get_theme_mod('urbantaxi_first_theme_color', '#FDC702');
    $urbantaxi_second_theme_color = get_theme_mod('urbantaxi_second_theme_color', '#ffffff');
    $urbantaxi_third_theme_color = get_theme_mod('urbantaxi_third_theme_color', '#2B2B2B');

    $urbantaxi_theme_custom_setting_css .=':root {';
        $urbantaxi_theme_custom_setting_css .='--urbantaxi-primary-theme-color: '.sanitize_hex_color($urbantaxi_first_theme_color ).'!important;';
        $urbantaxi_theme_custom_setting_css .='--urbantaxi-secondary-theme-color: '.sanitize_hex_color($urbantaxi_second_theme_color ).'!important;';
        $urbantaxi_theme_custom_setting_css .='--urbantaxi-tertiary-theme-color: '.sanitize_hex_color($urbantaxi_third_theme_color ).'!important;';
    $urbantaxi_theme_custom_setting_css .='}';

    // Scroll to top alignment (sanitize and use a safe key)
    $urbantaxi_scroll_alignment = sanitize_key( get_theme_mod( 'urbantaxi_scroll_alignment', 'right' ) );

    if($urbantaxi_scroll_alignment == 'right'){
        $urbantaxi_theme_custom_setting_css .='.scroll-up{';
            $urbantaxi_theme_custom_setting_css .='right: 30px !important;';
			$urbantaxi_theme_custom_setting_css .='left: auto !important;';
        $urbantaxi_theme_custom_setting_css .='}';
    }else if($urbantaxi_scroll_alignment == 'center'){
        $urbantaxi_theme_custom_setting_css .='.scroll-up{';
            $urbantaxi_theme_custom_setting_css .='left: calc(50% - 10px) !important;';
        $urbantaxi_theme_custom_setting_css .='}';
    }else if($urbantaxi_scroll_alignment == 'left'){
        $urbantaxi_theme_custom_setting_css .='.scroll-up{';
            $urbantaxi_theme_custom_setting_css .='left: 30px !important;';
			$urbantaxi_theme_custom_setting_css .='right: auto !important;';
        $urbantaxi_theme_custom_setting_css .='}';
    }
