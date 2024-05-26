<?php

add_action('acf/include_fields', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(
        array (
            'key' => 'group_6650d45931a15',
            'title' => 'testimanial fields',
            'fields' => array (
                array (
                    'key' => 'field_6650d45999e49',
                    'label' => 'Costumers Photo',
                    'name' => 'costumers_photo',
                    'aria-label' => '',
                    'type' => 'image',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'array',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                    'preview_size' => 'medium',
                ),
                array (
                    'key' => 'field_6650d4ba99e4a',
                    'label' => 'Date of Testimonial',
                    'name' => 'date_',
                    'aria-label' => '',
                    'type' => 'date_picker',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'display_format' => 'd/m/Y',
                    'return_format' => 'd/m/Y',
                    'first_day' => 1,
                ),
            ),
            'location' => array (
                array (
                    array (
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'testimonial',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
            'show_in_rest' => 0,
        ));
});

add_action('init', function () {
    register_post_type('testimanial', array (
        'labels' => array (
            'name' => 'testimonials',
            'singular_name' => 'testimanial',
            'menu_name' => 'testimonials',
            'all_items' => 'All testimonials',
            'edit_item' => 'Edit testimanial',
            'view_item' => 'View testimanial',
            'view_items' => 'View testimonials',
            'add_new_item' => 'Add New testimanial',
            'add_new' => 'Add New testimanial',
            'new_item' => 'New testimanial',
            'parent_item_colon' => 'Parent testimanial:',
            'search_items' => 'Search testimonials',
            'not_found' => 'No testimonials found',
            'not_found_in_trash' => 'No testimonials found in Trash',
            'archives' => 'testimanial Archives',
            'attributes' => 'testimanial Attributes',
            'insert_into_item' => 'Insert into testimanial',
            'uploaded_to_this_item' => 'Uploaded to this testimanial',
            'filter_items_list' => 'Filter testimonials list',
            'filter_by_date' => 'Filter testimonials by date',
            'items_list_navigation' => 'testimonials list navigation',
            'items_list' => 'testimonials list',
            'item_published' => 'testimanial published.',
            'item_published_privately' => 'testimanial published privately.',
            'item_reverted_to_draft' => 'testimanial reverted to draft.',
            'item_scheduled' => 'testimanial scheduled.',
            'item_updated' => 'testimanial updated.',
            'item_link' => 'testimanial Link',
            'item_link_description' => 'A link to a testimanial.',
        ),
        'public' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-admin-post',
        'supports' => array (
            0 => 'title',
            1 => 'editor',
            2 => 'thumbnail',
            3 => 'custom-fields',
        ),
        'delete_with_user' => false,
    ));
});

