<?php

/**
 * ellak - edu_fos delete posts utility plugin
 *
 * @package     none
 * @author      David Bromoiras
 * @copyright   oat-eellak
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: edu_fos delete posts utility plugin
 * Plugin URI:  
 * Description: 
 * Version:     0.1
 * Author:      David Bromoiras
 * Author URI:  https://www.anchor-web.gr
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 **/

if (post_type_exists('edu_fos')) {
    register_activation_hook(__FILE__, 'delete_edu_fos_posts');
    function delete_edu_fos_posts(){
        //if($wp_query->is_main_query()){
            $wp_my_query=new WP_Query(array('post_type'=>'edu_fos', 'posts_per_page'=>-1));
            if($wp_my_query->have_posts()){
                while($wp_my_query->have_posts()){
                    $wp_my_query->the_post();
                    wp_delete_post(get_the_ID(), true);
                }
            }
        //}
    }
    
    register_activation_hook(__FILE__, 'clear_taxonomy_terms');
    function clear_taxonomy_terms(){
        $taxonomies_to_clear=array('edu_fos_thematiki', 'edu_fos_antikimeno', 'edu_fos_vathmida', 'edu_fos_adia', 'edu_fos_idos', 'edu_fos_litourgiko');
        foreach($taxonomies_to_clear as $tmp_taxonomy){
            $terms_to_clear=get_terms(array('taxonomy'=>$tmp_taxonomy));
            if(!is_wp_error($terms_to_clear)){
                if(!empty($terms_to_clear)){
                    error_log(var_dump($terms_to_clear));
                    foreach($terms_to_clear as $tmp_term){
                        wp_delete_term($tmp_term->term_id, $tmp_term->taxonomy);
                    }
                }
            }
        }
    }
}

