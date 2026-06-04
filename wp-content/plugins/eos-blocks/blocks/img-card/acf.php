<?php
			if( function_exists('acf_add_local_field_group') ):

                acf_add_local_field_group(array(
                    'key' => 'group_6386beeb4b3f4',
                    'title' => 'block: 圖文卡片',
                    'fields' => array(
                        array(
                            'key' => 'field_6386beebc4740',
                            'label' => '圖片',
                            'name' => 'img',
                            'aria-label' => '',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'id',
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
                        array(
                            'key' => 'field_6386bf02c4741',
                            'label' => '說明文字',
                            'name' => 'text',
                            'aria-label' => '',
                            'type' => 'textarea',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'maxlength' => '',
                            'rows' => 4,
                            'placeholder' => '',
                            'new_lines' => '',
                        ),
                        array(
                            'key' => 'field_6386bf0fc4742',
                            'label' => '按鈕連結',
                            'name' => 'link',
                            'aria-label' => '',
                            'type' => 'link',
                            'instructions' => '可留空僅顯示文字',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'array',
                        ),
                    ),
                    'location' => array(
                        array(
                            array(
                                'param' => 'block',
                                'operator' => '==',
                                'value' => 'acf/img-card',
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
                
                endif;		
?>