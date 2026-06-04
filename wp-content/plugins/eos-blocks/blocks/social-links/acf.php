<?php
			if( function_exists('acf_add_local_field_group') ):

                acf_add_local_field_group(array(
                    'key' => 'group_636db9f097993',
                    'title' => 'block: 自訂社群媒體',
                    'fields' => array(
                        array(
                            'key' => 'field_636db9f0837a2',
                            'label' => '社群媒體',
                            'name' => 'social_medias',
                            'aria-label' => '',
                            'type' => 'repeater',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'layout' => 'table',
                            'pagination' => 0,
                            'min' => 0,
                            'max' => 0,
                            'collapsed' => '',
                            'button_label' => '新增列',
                            'rows_per_page' => 20,
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_636dba1d837a3',
                                    'label' => 'type',
                                    'name' => 'type',
                                    'aria-label' => '',
                                    'type' => 'select',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'choices' => array(
                                        'fb' => 'FB',
                                        'line' => 'Line',
                                        'instagram' => 'IG'
                                    ),
                                    'default_value' => 'fb',
                                    'return_format' => 'value',
                                    'multiple' => 0,
                                    'allow_null' => 0,
                                    'ui' => 0,
                                    'ajax' => 0,
                                    'placeholder' => '',
                                    'parent_repeater' => 'field_636db9f0837a2',
                                ),
                                array(
                                    'key' => 'field_636dba38837a4',
                                    'label' => 'link',
                                    'name' => 'link',
                                    'aria-label' => '',
                                    'type' => 'url',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => '',
                                    'placeholder' => '',
                                    'parent_repeater' => 'field_636db9f0837a2',
                                ),
                            ),
                        ),
                    ),
                    'location' => array(
                        array(
                            array(
                                'param' => 'block',
                                'operator' => '==',
                                'value' => 'acf/social-links',
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