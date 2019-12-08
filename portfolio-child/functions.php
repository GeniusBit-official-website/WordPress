<?php

// 子テーマのstyle.cssを後から読み込む
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('style')
    );
}
// 追加したいコードを以下に記述

// ホーム画面にリンクを表示するかどうかをカスタマイズ画面で設定できるようにする
function work_metaboxes_on_page( $meta_boxes ) {
    $prefix = '_wk_'; // Prefix for all fields
    $meta_boxes['work_metabox'] = array(
        'id' => 'work_metabox',
        'title' => 'Sticky Post',
		// post type にpage（固定ページを追加）
        'pages' => array('post', 'page', 'work'),
        'context' => 'side',
        'priority' => 'low',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
    			'name' => 'Stick This Post To Front Page',
    			'id' => $prefix . 'work_checkbox',
    			'type' => 'checkbox'
			),
        ),
    );

    return $meta_boxes;
}

// 親テーマ読み込み後に読み込まれる
function set_after_parent_theme() {
	// 親テーマでaddされたfilterを上書き
	remove_filter('cmb_meta_boxes', 'work_metaboxes');
	add_filter( 'cmb_meta_boxes', 'work_metaboxes_on_page' );
}

add_filter('after_setup_theme', 'set_after_parent_theme', 20);

?>
