<?php 
namespace Drupal\gavias_blockbuilder\shortcodes;
if(!class_exists('gsc_our_class_kh')):
   class gsc_our_class_kh{

      public function render_form(){
         $fields = array(
            'type'   => 'gsc_our_class_kh',
            'title'  => t('Our Class Image'), 
            'size'   => 3,
            'icon'   => 'fa fa-bars',
            'fields' => array(
               array(
                  'id'        => 'title',
                  'type'      => 'text',
                  'title'     => t('title Admin'),
                  'class'     => 'display-admin'
               ),
               array(
                  'id'        => 'el_class',
                  'type'      => 'text',
                  'title'     => t('Extra class name'),
                  'desc'      => t('Style particular content element differently - add a class name and refer to it in custom CSS.'),
               ),
               array(
                  'id'        => 'animate',
                  'type'      => 'select',
                  'title'     => t('Animation'),
                  'sub_desc'  => t('Entrance animation'),
                  'options'   => gavias_blockbuilder_animate()
               ),
            ),                                      
         );

         for($i=1; $i<=10; $i++){
            $fields['fields'][] = array(
               'id'     => "info_${i}",
               'type'   => 'info',
               'desc'   => "Information for item {$i}"
            );
            $fields['fields'][] = array(
               'id'        => "title_{$i}",
               'type'      => 'text',
               'title'     => t("Title {$i}")
            );
            $fields['fields'][] = array(
               'id'        => "image_{$i}",
               'type'      => 'upload',
               'title'     => t("Image {$i}")
            );
            $fields['fields'][] = array(
               'id'        => "time_{$i}",
               'type'      => 'text',
               'title'     => t("Time {$i}")
            );
            $fields['fields'][] = array(
               'id'        => "link_{$i}",
               'type'      => 'text',
               'title'     => t("Link {$i}")
            );
         }

         return $fields;
      }

      public function render_content( $item ) {
         if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
         print self::sc_our_class( $item['fields'], $item['fields']['content'] );
      }

      public static function sc_our_class( $attr, $content = null ){
         global $base_url;
         $default = array(
            'title'        => '',
            'el_class'     => '',
            'animate'      => '',
         );
      
        for($i=1; $i<=10; $i++){
            $default["title_{$i}"] = '';
            $default["image_{$i}"] = '';
            $default["time_{$i}"] = '';
            $default["link_{$i}"] = '';
         }

         extract(shortcode_atts($default, $attr));
         $data_item_lg = $data_item_md = 2;
         if($animate){
            $el_class .= ' wow';
            $el_class .= ' ' . $animate;
         }
          ob_start();
         ?>
      
            <div class="gsc-our-class">
               <div class="owl-carousel init-carousel-owl owl-loaded owl-drag" data-items="<?php print $data_item_lg ?>" data-items_lg="<?php print $data_item_lg ?>" data-items_md="<?php print $data_item_md ?>" data-items_sm="2" data-items_xs="1" data-loop="1" data-speed="500" data-auto_play="1" data-auto_play_speed="2000" data-auto_play_timeout="5000" data-auto_play_hover="1" data-navigation="1" data-rewind_nav="0" data-pagination="0" data-mouse_drag="1" data-touch_drag="1">
               <?php for($i=1; $i<=10; $i++): ?>
                  <?php 
                     $title = "title_{$i}";
                     $image = "image_{$i}";
                     $link = "link_{$i}";
                     $time = "time_{$i}";
                     if($$image) $$image = $base_url . $$image;
                  ?>
               
                     <div class="item">
                        <div class="gsc-our-class-item">
                           <div class="image"><img src="<?php print $$image ?>" /></div>
                     
                        </div>
                     </div>   
             
               <?php endfor; ?>   
               </div>   
            </div>   
         <?php $output = ob_get_clean(); return $output; ?>
         <?php
      }

      public function load_shortcode(){
         add_shortcode( 'our_class', array('gsc_our_class', 'sc_our_class' ));
      }
   }
endif;


