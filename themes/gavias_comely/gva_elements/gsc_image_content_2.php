<?php 
namespace Drupal\gavias_blockbuilder\shortcodes;
if(!class_exists('gsc_image_content_2')):
   class gsc_image_content_2{
      public function render_form(){
         return array(
           'type'          => 'gsc_image_content_2',
            'title'        => t('Image content rate'),
            'size'         => 3,
            'icon'         => 'fa fa-bars',
            'fields' => array(
            
               array(
                  'id'        => 'title',
                  'type'      => 'text',
                  'title'     => t('Title'),
                  'class'     => 'display-admin'
               ),
               array(
                  'id'        => 'background',
                  'type'      => 'upload',
                  'title'     => t('Background images')
               ),
               array(
                  'id'        => 'content',
                  'type'      => 'textarea',
                  'title'     => t('Content'),
                  'desc'      => t('Some HTML tags allowed'),
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
                  'std'       => 'on'
               ),

               array(
                  'id'        => 'skin',
                  'type'      => 'select',
                  'title'     => t('Skin'),
                  'options'   => array( 
                     'skin-v1' => t('Skin #1'), 
                     'skin-v2' => t('Skin #2'), 
                  ),
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
            print self::sc_image_content( $item['fields'], $item['fields']['content'] );
      }

      public static function sc_image_content( $attr, $content = null ){
         global $base_url;
         extract(shortcode_atts(array(
            'title'              => '',
            'icon'               => '',
            'background'         => '',
            'link'               => '',
            'target'             => '',
            'skin'               => 'skin-v1',
            'el_class'           => '',
            'animate'            => ''
         ), $attr));

         // target
         if( $target =='on' ){
            $target = 'target="_blank"';
         } else {
            $target = false;
         }
         
         if($background) $background = $base_url . $background; 

         if($animate){
            $el_class .= ' wow';
            $el_class .= ' ' . $animate;
         }

         if($skin) $el_class .= ' ' . $skin;
          ob_start();
         ?>
   

         <div class="gsc-image-content-rate <?php print $el_class; ?>">
            <div class="content">
               <div class="box">
                  <?php if($title){ ?><?php if($link){ ?><a <?php print $target ?> href="<?php print $link ?>"><?php } ?>
                     <div class="image-rate">
                        <img class="img-user" src="<?php print $background ?>" alt="<?php print $title ?>" />
                     </div>
                     <div class="box-star">
                        <div class="stars">
                           <img src="<?php $base_url ?>/sites/default/files/gbb-uploads/customize_mees/star.png" style="width: 15px;    margin-left: 25px;">
                           <img src="<?php $base_url ?>/sites/default/files/gbb-uploads/customize_mees/star.png" style="width: 15px;">
                           <img src="<?php $base_url ?>/sites/default/files/gbb-uploads/customize_mees/star.png" style="width: 15px;">
                           <img src="<?php $base_url ?>/sites/default/files/gbb-uploads/customize_mees/star.png" style="width: 15px;">
                           <img src="<?php $base_url ?>/sites/default/files/gbb-uploads/customize_mees/star.png" style="width: 15px;">
                        </div>
                     </div>
                     <h5 class="title" style="text-align: center; font-size: 16px; margin-top: 10px;"><?php print $title ?></h5>
                  <?php if($link){ ?></a><?php } ?><?php } ?>  
                  <img src="<?php $base_url ?>/sites/default/files/gbb-uploads/customize_mees/image-list-start.png" alt="">
                  <br>
               </div>
               <!-- <div class="desc"><?php print $content; ?></div> -->
               <?php if($link){ ?>
                  <div class="action" ><a <?php print $target ?> href="<?php print $link ?>"><?php print t('Read more') ?></a></div>
               <?php } ?>  
            </div>  
         </div>

         <?php return ob_get_clean() ?>
        <?php            
      } 

      public function load_shortcode(){
         add_shortcode( 'image_content', array($this, 'sc_image_content'));
      }
   }
endif;   
