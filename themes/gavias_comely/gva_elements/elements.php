<?php
function gavias_blockbuilder_get_elements(){
   return $shortcodes = array(
    'gsc_box_title_single',
    'gsc_box_button',
    'gsc_column_title_single',
    'gsc_box_image_content',
    'gsc_box_image_content_v2',
    'gsc_box_text_customize',
    'gsc_box_text_customize_border_left',
    'gsc_accordion',
    'gsc_box_text_content_check_one_column',
    'gsc_accordion_menu',
    'gsc_box_hover', 
    'gsc_box_text_title',
    'gsc_box_info',
    'gsc_box_text',
    'gsc_box_text_header',
    'gsc_box_text_content',
    'gsc_box_text_content_aside_right',
    'gsc_box_text_content_aside_right_one_column',
   //  'gsc_call_to_action',
   //  'gsc_chart',
   //  'gsc_code',
    'gsc_column',
    'gsc_column_no_editor',
    'gsc_counter',
    'gsc_drupal_block',
    'gsc_heading',
    'gsc_icon_box',
    'gsc_image',
    'gsc_our_team',
    'gsc_pricing_item',
    'gsc_progress',
    'gsc_tabs',
   //  'gsc_video_box',
   //  'gsc_gmap',
    'gsc_button',
    'gsc_view',
    'gsc_quote_text',
    'gsc_work_process',
    'gsc_image_content',
    'gsc_image_content_1',
    'gsc_image_content_2',
    'gsc_services_carousel',
    'gsc_our_history',
    'gsc_gallery',
    'gsc_our_partners',
    'gsc_download',
    'gsc_socials',
    'gsc_instagram',
    'gsc_carousel_content',
    'gsc_divider',
   //  'gsc_testimonial_single',
    'gsc_timeline',
    'gsc_our_class',
    'gsc_our_class_kh',
    'gsc_our_menu',
    'gsc_view_tabs_ajax'
  );
}

function scrape_insta_hash($tag) {
   $insta_source = file_get_contents('https://www.instagram.com/'.trim($tag)); // instagrame tag url
   $shards = explode('window._sharedData = ', $insta_source);
   $insta_json = explode(';</script>', $shards[1]); 
   $insta_array = json_decode($insta_json[0], TRUE);
   return $insta_array; // this return a lot things print it and see what else you need
}