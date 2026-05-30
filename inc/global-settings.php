<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

if ( function_exists( 'get_current_site' ) ) {
    $site = get_current_site();
    $site = $site->site_name;
} else {
    $site = get_bloginfo('name');
}

return array(
    "colors_enable_styleguide_preview" => "yes",
    "system_colors" => array(
        array(
            "_id" => "primary",
            "title" => "Primary",
            "color" => "#FDC702"
        ),
        array(
            "_id" => "secondary",
            "title" => "Secondary",
            "color" => "#111317"
        ),
        array(
            "_id" => "text",
            "title" => "Text",
            "color" => "#0B0B0B"
        ),
        array(
            "_id" => "accent",
            "title" => "Accent",
            "color" => "#ffffff"
        )
    ),
    "custom_colors" => array(),
    "system_typography" => array(
        array(
            "_id" => "primary",
            "title" => "Primary",
            "typography_typography" => "custom",
            "typography_font_family" => "Lexend",
            "typography_font_weight" => "600",
            "typography_font_size" => array (
                "unit" => "px",
                "size" => "40",
                "sizes" => array()
            ),
            "typography_text_transform" => "capitalize",
            "typography_line_height" => array(
                "unit" => "px",
                "size" => "55",
                "sizes" => array()
            )
        ),
        array(
            "_id" => "secondary",
            "title" => "Secondary",
            "typography_typography" => "custom",
            "typography_font_family" => "Lexend",
            "typography_font_weight" => "600",
            "typography_font_size" => array (
                "unit" => "px",
                "size" => "28",
                "sizes" => array()
            ),
            "typography_text_transform" => "capitalize",
            "typography_line_height" => array(
                "unit" => "px",
                "size" => "40",
                "sizes" => array()
            )
        ),
        array(
            "_id" => "text",
            "title" => "Text",
            "typography_typography" => "custom",
            "typography_font_family" => "Roboto",
            "typography_font_weight" => "400",
            "typography_text_transform" => "capitalize",
            "typography_font_size" => array (
                "unit" => "px",
                "size" => "14",
                "sizes" => array()
            ),
            "typography_line_height" => array(
                "unit" => "px",
                "size" => "25",
                "sizes" => array()
            )
        ),
        array(
            "_id" => "accent",
            "title" => "Accent",
            "typography_typography" => "custom",
            "typography_font_family" => "Lexend",
            "typography_font_weight" => "500",
            "typography_text_transform" => "capitalize",
            "typography_font_size" => array (
                "unit" => "px",
                "size" => "18",
                "sizes" => array()
            ),
            "typography_line_height" => array(
                "unit" => "px",
                "size" => "24",
                "sizes" => array()
            )
        )
    ),
    "custom_typography" => array(),
    "default_generic_fonts" => "Sans-serif",
    "site_name" => $site,
    "page_title_selector" => "h1.entry-title",
    "activeItemIndex" => 1,
    "viewport_md" => 768,
    "viewport_lg" => 1025,
    "active_breakpoints" => array(
        "viewport_mobile",
        "viewport_mobile_extra",
        "viewport_tablet",
        "viewport_tablet_extra",
        "viewport_laptop",
        "viewport_widescreen"
    ),
    "container_width" => array(
        "unit" => "px",
        "size" => "1320",
        "sizes" => array()
    )
);