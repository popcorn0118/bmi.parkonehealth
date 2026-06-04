<?php

function get_post_by_weight($data) { 
    
    $weight = explode('-', $data['weight']);

    // get result post
    $args = array(
        'numberposts'=> 1,
        'post_type'  => 'case',
        'meta_query' => array(
            'key' => 'body_data_weight_after',
            'value' => $weight[0],
            'compare' => '>=',
        ),
        'orderby'   => 'meta_value_num',
        'meta_key'  => 'body_data_weight_after',
        'order'     => 'ASC',
    );
    
    $post = get_posts($args);

    // 沒有文章時找小於低標的第一個文章 (最大值)
    if ( sizeof($post) < 1 ) {
        $args = array(
            'numberposts'=> 1,
            'post_type'  => 'case',
            'meta_query' => array(
                'key' => 'body_data_weight_after',
                'value' => $weight[0],
                'compare' => '<=',
            ),
            'orderby'   => 'meta_value_num',
            'meta_key'  => 'body_data_weight_after',
            'order'     => 'DESC',
        );
        $post = get_posts($args);
    }

    $category = '';
    foreach($post[0]->category as $index => $cat_ID):
        $term = get_term_by('id', $cat_ID, 'treat_type');
        if($index > 0):
            $category .= '、';
        endif;
        $category .= $term->name;
    endforeach;

    $result['id'] = $post[0]->ID;
    $result['date'] = get_the_date('', $post[0]);
    $result['title'] = str_replace(' ', '<br />',get_the_title($post[0]));
    $result['time'] = $post[0]->time;
    $result['category'] = $category;
    $result['weight_before'] = $post[0]->body_data_weight_before;
    $result['weight_after'] = $post[0]->body_data_weight_after;
    $result['link'] = get_permalink($post[0]);

    return rest_ensure_response( $result );
}
 

function prefix_register_example_routes() {
    register_rest_route( 'get-post/v1', '/weight/(?P<weight>[0-9-]+)', array(
        'methods'  => 'GET',
        'callback' => 'get_post_by_weight',
    ) );
}
 
add_action( 'rest_api_init', 'prefix_register_example_routes' );

?>