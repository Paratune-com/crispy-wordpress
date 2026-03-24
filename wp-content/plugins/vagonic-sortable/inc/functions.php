<?php
delete_option('vagonic_sortable_lite_plugin_name');
add_option('vagonic_sortable_lite_plugin_name', 'vagonic-sortable-lite');

//====== Category Class ======
if (!class_exists('VagonicSortableLiteCategory')) {
    class VagonicSortableLiteCategory
    {
        public $id;
        function set_id($id)
        {
            $this->id = $id;
        }

        public $value;
        function set_value($value)
        {
            $this->value = $value;
        }
    }
}

//====== Sorting ======
if (!function_exists('vagonic_sortable_lite_get_taxonomy_hierarchy')) {
    function vagonic_sortable_lite_get_taxonomy_hierarchy($taxonomy, $parent = 0, $number = 8)
    {
        $y=0;
        if($taxonomy=="tag") {
            $children=[];
        }else{
            $taxonomy = is_array($taxonomy) ? array_shift($taxonomy) : $taxonomy;
            $terms = get_terms(
                array(
                    'taxonomy' => $taxonomy,
                    'parent' => $parent,
                    'orderby' => 'menu_order',
                    'order' => 'asc',
                    'hide_empty' => true,
                    'number' => $number,
                )
            );

            $children = array();
            foreach ($terms as $term) {
                $y++;
                $cat = new VagonicSortableLiteCategory();
                $cat->set_value($term->name);
                $cat->set_id($term->term_id);
                array_push($children, $cat);
            }
        }
        return $children;
    }
}

//====== Get Products ======
if (!function_exists('vagonic_sortable_lite_get_products')) {
    function vagonic_sortable_lite_get_products($id, $type, $isPrice, $isStock)
    {
        $params = array(
            'post_type'         => 'product',
            'posts_per_page'     => 999999,
            'orderby'             => 'menu_order',
            'order'             => 'ASC',
            'post_status'        => array('publish'),
            'tax_query' => array(
                array(
                    'taxonomy' => ($type) ? 'product_cat' : 'product_tag',
                    'field' => 'term_id',
                    'terms' => $id
                )
            ),
        );
    
        $meta_query = array();
    
        if (!$isPrice) {
            $meta_query = array_merge($meta_query, array(array(
                'key' => '_price',
                'value' => '0',
                'compare' => '>'
            )));
        }
    
        if (!$isStock) {
            $meta_query = array_merge($meta_query, array(array(
                'key' => '_stock_status',
                'value' => 'instock',
                'compare' => '='
            )));
        }
    
        $params = array_merge($params, array('meta_query' => $meta_query));
    
        $wc_query = new WP_Query($params);
    
        if ($wc_query->have_posts()) :
            $counter = 0;
            while ($wc_query->have_posts()) : $wc_query->the_post();
                global $post;
                $product = wc_get_product($post->ID);
    ?>
                <div class="card-vagonic">
                    <div class="card card-product">
                        <div class="card-product-content">
                            <div class="draggable">
                                <div class="card-avatar">
                                    <a>
                                        <?php echo $counter + 1; ?>
                                    </a>
                                </div>
                                <div class="card-header card-header-image">
                                    <a>
                                        <?php echo $product->get_image('woocommerce_gallery_thumbnail', array('class' => 'img')); ?>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="product_id[]" value="<?php echo $post->ID; ?>">
                                    <input type="hidden" name="menu_order[]" value="<?php echo $counter; ?>">
                                    <div class="card-stock-code"><?php echo $product->get_sku(); ?></div>
                                    <div class="card-title"><?php the_title(); ?></div>
                                    <div class="card-price"><?php echo $product->get_price_html(); ?></div>
    
                                </div>
                            </div>
                            <div class="buttons">
                                <div class="d-flex justify-content-center button-vagonic">
                                    <div class="d-flex flex-row">
                                        <div>
                                            <a class="btn btn-fab btn-icon" data-toggle="tooltip" data-placement="bottom" title="Ürünü Düzenle" target="_blank" href="<?php echo get_edit_post_link($post->ID); ?>">
                                                <i class="material-icons">edit</i>
                                            </a>
                                        </div>
                                        <div>
                                            <a class="btn btn-fab btn-icon" data-toggle="tooltip" data-placement="bottom" title="Ürüne Gözat" target="_blank" href="<?php echo get_permalink($post->ID); ?>">
                                                <i class="material-icons">open_in_new</i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
    <?php
                $counter++;
            endwhile;
        endif;
        wp_reset_postdata();
    }
}

?>