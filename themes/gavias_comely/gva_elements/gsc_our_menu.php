<?php 
namespace Drupal\gavias_blockbuilder\shortcodes;
if(!class_exists('gsc_our_menu')):
   class gsc_our_menu{
      public function render_form(){
         return array(
           'type'          => 'gsc_our_menu',
            'title'        => t('Our menu'),
            'size'         => 3,
            'fields' => array(
               array(
                  'id'        => 'title',
                  'type'      => 'text',
                  'title'     => t('Title'),
                  'class'     => 'display-admin'
               ),
               array(
                  'id'        => 'image',
                  'type'      => 'upload',
                  'title'     => t('Upload')
               ),
               array(
                  'id'        => 'content',
                  'type'      => 'textarea',
                  'title'     => t('Menu')
               ),
               array(
                  'id'        => 'animate',
                  'type'      => 'select',
                  'title'     => t('Animation'),
                  'sub_desc'  => t('Entrance animation'),
                  'options'   => gavias_blockbuilder_animate(),
               ),
               array(
                  'id'        => 'el_class',
                  'type'      => 'text',
                  'title'     => t('Extra class name'),
                  'desc'      => t('Style particular content element differently - add a class name and refer to it in custom CSS.'),
               ),
            ),                                     
         );
      }

      public function render_content( $item ) {
         if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
            print self::sc_our_menu( $item['fields'], $item['fields']['content'] );
      }

      public static function sc_our_menu( $attr, $content = null ){
         global $base_url;
         extract(shortcode_atts(array(
            'title'              => '',
            'image'              => '',
            'content'            => '',
            'animate'            => '',
            'el_class'           => ''
         ), $attr));
         if($animate){
            $el_class .= ' wow';
            $el_class .= ' ' . $animate;
         }
         if($image) $image = $base_url . $image;
          ob_start();
         ?>
      
         <div class="widget gsc-our-menu <?php print $el_class ?>">
            <div class="content-inner">
               <div class="title"><?php print $title ?></div>
               <?php if($image){ ?>
                  <div class="image"><img src="<?php print $image ?>" alt="<?php print $title ?>"/></div>
               <?php } ?>   
               <?php if($content){ ?>
                  <div class="box-content"><?php print $content ?></div>
               <?php } ?>
            </div>
         </div>
         <?php return ob_get_clean() ?>
      <?php
      } 

      public function load_shortcode(){
         add_shortcode( 'our_menu', array($this, 'sc_our_menu'));
      }
   }
endif;   
