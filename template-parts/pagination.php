<?php
if (!defined('ABSPATH')) {
    exit;
}

$links = paginate_links(array(
    'type' => 'array',
    'prev_next' => false,
    'mid_size' => 1,
    'end_size' => 1,
));

if ($links) {
    echo '<div class="ut-pagination">';

    if (get_previous_posts_link()) {
        echo '<div class="ut-prev-wrap">' . wp_kses_post(
            get_previous_posts_link('<i class="fas fa-chevron-left"></i>')
        ) . '</div>';
    }
    else {
        echo '<div class="ut-prev-wrap disabled"><span><i class="fas fa-chevron-left"></i></span></div>';
    }

    echo '<div class="ut-pages">';

    foreach ($links as $link) {
        $modified_link = preg_replace_callback('/>(\d+)</', function($matches) {
            return '>' . str_pad($matches[1], 2, '0', STR_PAD_LEFT) . '<';
        }, $link);
        echo wp_kses_post($modified_link);
    }

    echo '</div>';

    if (get_next_posts_link()) {
        echo '<div class="ut-next-wrap">' . wp_kses_post(
            get_next_posts_link('<i class="fas fa-chevron-right"></i>')
        ) . '</div>';
    }
    else {
        echo '<div class="ut-next-wrap disabled"><span><i class="fas fa-chevron-right"></i></span></div>';
    }

    echo '</div>';
}