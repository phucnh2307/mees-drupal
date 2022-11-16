<?php 
namespace Drupal\gavias_blockbuilder\shortcodes;
if(!class_exists('gsc_box_text_header')):
   class gsc_box_text_header{
      public function render_form(){
         return array(
           'type'          => 'gsc_box_text_header',
            'title'        => t('Box Text Header'),
            'size'         => 3,
            'icon'         => 'fa fa-bars',
            'fields' => array(
               array(
                  'id'        => 'breadcrumb_1',
                  'type'      => 'text',
                  'title'     => t('Breadcrumb 1'),
                  'class'     => 'display-admin'
               ),
               array(
                  'id'        => 'breadcrumb_2',
                  'type'      => 'text',
                  'title'     => t('Breadcrumb 2'),
                  'class'     => 'display-admin'
               ),
               array(
                  'id'        => 'breadcrumb_3',
                  'type'      => 'text',
                  'title'     => t('Breadcrumb 3'),
                  'class'     => 'display-admin'
               ),
               array(
                  'id'        => 'title',
                  'type'      => 'text',
                  'title'     => t('Title'),
                  'class'     => 'display-admin'
               ),
               array(
                  'id'        => 'content',
                  'type'      => 'textarea',
                  'title'     => t('Content'),
               ),
               array(
                  'id'        => 'rate',
                  'type'      => 'text',
                  'title'     => t('Rate'),
                  'class'     => 'display-admin'
               ),
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
            'breadcrumb'         => '',
            'breadcrumb_1'       => '',
            'breadcrumb_2'       => '',
            'breadcrumb_3'       => '',
            'title'              => '',
            'rate'               => '',
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
        <br>
         <div class="gsc-box-text widget clearfix <?php print $el_class; ?>" <?php print $style; ?>>
            <?php if($title){ ?>
               <p style="font-size: 15px; color: #727272;"><span style="color: #FF6A47;"><?php print $breadcrumb_1 ?></span> / <span style="color: #FF6A47;"><?php print $breadcrumb_2 ?></span> / <span style="font-style: italic; color: #727272;"><?php print $breadcrumb_3 ?></span></p>
               <div class="title widget-title" style="font-size: 34px; color: white; font-weight: bold;"<?php print $style_title; ?>>
                  <?php if($link){ ?> <a href="<?php print $link ?>" <?php print $target ?>> <?php } ?> <?php print $title ?> <?php if($link){ ?> </a><?php } ?>
               </div>
               <hr style="margin-top: 15px; margin-bottom: 15px;">
            <?php } ?>
            <?php if($content){ ?>  
               <div class="box-content"><?php print $content ?></div>
            <?php } ?>   
         </div>
         <?php if($rate){ ?>  
         <div class="box-content">
            <div class="star-header" style="float: left; margin-top: 4px;">
               <img src="<?php $base_url ?>/sites/default/files/gbb-uploads/customize_mees/star.png" style="width: 15px;">
               <img src="<?php $base_url ?>/sites/default/files/gbb-uploads/customize_mees/star.png" style="width: 15px;">
               <img src="<?php $base_url ?>/sites/default/files/gbb-uploads/customize_mees/star.png" style="width: 15px;">
               <img src="<?php $base_url ?>/sites/default/files/gbb-uploads/customize_mees/star.png" style="width: 15px;">
               <img src="<?php $base_url ?>/sites/default/files/gbb-uploads/customize_mees/star.png" style="width: 15px;">
            </div>
            <div class="poin" style="float: left;  margin-right: 10px; color: white;"><span style="font-size: 16px; color: #F6C142; margin-left: 10px;  margin-right: 10px; font-weight: 600;">4.5</span>( 222 đánh giá )</div>  | <div class="name" style="float: left; margin-left: 10px;  margin-right: 10px; color: white; font-weight: 600; color: #FF5A33;">Triệu Nguyễn</div><span style=" margin-left: 10px; color: white;">Hướng dẫn</span>
         </div>
         <?php } ?> 
         <br>
         <?php return ob_get_clean() ?>
        <?php            
      } 

      public function load_shortcode(){
         add_shortcode( 'box_text', array($this, 'sc_box_text'));
      }
   }
endif;   
