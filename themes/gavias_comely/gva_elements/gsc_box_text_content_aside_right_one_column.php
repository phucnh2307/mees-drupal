<?php 
namespace Drupal\gavias_blockbuilder\shortcodes;
if(!class_exists('gsc_box_text_content_aside_right_one_column')):
   class gsc_box_text_content_aside_right_one_column{
      public function render_form(){
         return array(
           'type'          => 'gsc_box_text_content_aside_right_one_column',
            'title'        => t('Box Text Content Aside Right One'),
            'size'         => 3,
            'icon'         => 'fa fa-bars',
            'fields' => array(
               array(
                  'id'        => 'title_left',
                  'type'      => 'text',
                  'title'     => t('Title Left'),
                  'class'     => 'display-admin'
               ),
               // array(
               //    'id'        => 'title_right',
               //    'type'      => 'text',
               //    'title'     => t('Title Right'),
               //    'class'     => 'display-admin'
               // ),
               // array(
               //    'id'        => 'content',
               //    'type'      => 'textarea',
               //    'title'     => t('Content'),
               // ),
               array(
                  'id'        => 'background',
                  'type'      => 'text',
                  'title'     => t('Background Box'),
                  'desc'      => t('Use color name ( blue ) or hex ( #2991D6 )'),
               ),
                array(
                  'id'        => 'title_color',
                  'type'      => 'text',
                  'title'     => t('Color for title'),
                  'desc'      => t('Use color name ( blue ) or hex ( #2991D6 )'),
               ),
               array(
                  'id'        => 'link',
                  'type'      => 'text',
                  'title'     => t('Link'),
               ),
               array(
                  'id'        => 'target',
                  'type'      => 'select',
                  'title'     => t('Open in new window'),
                  'desc'      => t('Adds a target="_blank" attribute to the link'),
                  'options'   => array( 'off' => 'No', 'on' => 'Yes' ),
                  
               ),
               array(
                  'id'        => 'height',
                  'type'      => 'text',
                  'title'     => t('Min height for box'),
                   'desc'      => t('Setting min height for box, e.g: 200px')
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
                  'desc'      => t('Entrance animation'),
                  'options'   => gavias_blockbuilder_animate(),
               ),
         
            ),                                     
         );
      }

      public function render_content( $item ) {
         if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
            print self::sc_box_text( $item['fields'], $item['fields']['content'] );
      }

      public static function sc_box_text( $attr, $content = null ){
         global $base_url;
         extract(shortcode_atts(array(
            'title_left'         => '',
            'content'            => '',
            'background'         => '',
            'title_color'        => '',
            'link'               => '',
            'target'             => '',
            'height'             => '',
            'el_class'           => '',
            'animate'            => ''
         ), $attr));

         // target
         if( $target ){
            $target = 'target="_blank"';
         } else {
            $target = false;
         }

         $style = '';
         if($background) $style = "background: {$background};";
         if($height) $style .= "min-height: {$height};";
         if($style) $style = 'style="'.$style.'"';

         $style_title = '';
         if($title_color) $style_title = 'style="color: ' . $title_color . '"';
         
         if($animate){
            $el_class .= ' wow';
            $el_class .= ' ' . $animate;
         }
          ob_start();
         ?>
        
         <div class="widget clearfix <?php print $el_class; ?>" <?php print $style; ?>>
            <?php if($title_left){ ?>
               <div class="row">
                  <div class="title widget-title" <?php print $style_title; ?>>
                     <img src="<?php $base_url ?>/sites/default/files/gbb-uploads/customize_mees/check.png" alt="">
                     <?php if($link){ ?> <a href="<?php print $link ?>" <?php print $target ?>> <?php } ?> <?php print $title_left ?> <?php if($link){ ?> </a><?php } ?>
                  </div>
               </div>
               <hr style="margin-top: 10px; margin-bottom: 10px;">
            <?php } ?>
            <?php if($content){ ?>  
               <div class="box-content"><?php print $content ?></div>
            <?php } ?>   
         </div>
         <?php return ob_get_clean() ?>
        <?php            
      } 

      public function load_shortcode(){
         add_shortcode( 'box_text', array($this, 'sc_box_text'));
      }
   }
endif;   
