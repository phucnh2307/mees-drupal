<?php 
namespace Drupal\gavias_blockbuilder\shortcodes;
if(!class_exists('gsc_box_button')):
   class gsc_box_button{
      public function render_form(){
         return array(
           'type'          => 'gsc_box_button',
            'title'        => t('Box Button'),
            'size'         => 3,
            'icon'         => 'fa fa-bars',
            'fields' => array(
               array(
                  'id'        => 'link_1',
                  'type'      => 'text',
                  'title'     => t('Link Prev'),
                  'class'     => 'display-admin'
               ),
               array(
                  'id'        => 'link_2',
                  'type'      => 'text',
                  'title'     => t('Link Next'),
                  'class'     => 'display-admin'
               ),
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
            'link_1'              => '',
            'link_2'              => '',
            // 'content'            => '',
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
        
         <div class="gsc-box-text widget clearfix <?php print $el_class; ?>" <?php print $style; ?>>
            <div class="row">
               <div class="col-sm-6">
                  <a href="<?php print $link_1; ?>">
                     <div 
                        class="btn btn-next" 
                        style="border-radius: 4px; width: 150px; height: 40px; line-height: 30px; text-align: center;"
                     > <img style="margin-top: 3px;" src="<?php $base_url ?>/sites/default/files/gbb-uploads/customize_mees/icon-prev.png" alt=""> BÀI SAU
                     </div>
                  </a>
               </div>
               <div class="col-sm-6 text-right">
                 <a href="<?php print $link_2; ?>">
                     <div 
                        class="btn btn-next" 
                        style="border-radius: 4px; width: 150px; height: 40px; line-height: 30px; text-align: center;"
                     >
                        BÀI TRƯỚC <img style="margin-top: 3px;" src="<?php $base_url ?>/sites/default/files/gbb-uploads/customize_mees/icon-next.png" alt="">
                     </div>
                  </a>
               </div>
            </div>
         </div>
         <?php return ob_get_clean() ?>
        <?php            
      } 

      public function load_shortcode(){
         add_shortcode( 'box_text', array($this, 'sc_box_text'));
      }
   }
endif;   
