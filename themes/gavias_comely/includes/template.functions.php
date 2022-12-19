<?php
use Drupal\Core\Url;

function gavias_comely_base_url(){
  global $base_url;
  $theme_path = drupal_get_path('theme', 'gavias_comely');
  return $base_url . '/' . $theme_path . '/';
}

function gavias_comely_preprocess_node(&$variables) {
  $date = $variables['node']->getCreatedTime();
  $variables['date'] = date( 'j', $date) . ' ' . t(date( 'F', $date)) . ' ' . date( 'Y', $date);
  $variables['is_login'] = \Drupal::currentUser()->isAuthenticated();
  if ($variables['teaser'] || !empty($variables['content']['comments']['comment_form'])) {
    unset($variables['content']['links']['comment']['#links']['comment-add']);
  }
  if ($variables['node']->getType() == 'article' || $variables['node']->getType() == 'wordbench' || $variables['node']->getType() == 'bookcase') {
      $node = $variables['node'];
      if ($variables['node']->getType() != 'bookcase') {
        $variables['comment_count'] = $node->get('comment')->comment_count;
      }
      $post_format = 'standard';
      try{
         $field_post_format = $node->get('field_post_format');
         if(isset($field_post_format->value) && $field_post_format->value){
            $post_format = $field_post_format->value;
         }
      }catch(Exception $e){
         $post_format = 'standard';
      }

      $variables['node_view_count'] = 0;
      if (!empty($variables['node'])) {
        // Get the number of times the current node has been viewed.
        /** @var \Drupal\statistics\StatisticsViewsResult $statistics */
        $statistics = \Drupal::service('statistics.storage.node')
          ->fetchView($variables['node']->id());
          if ($statistics) {
            $variables['node_view_count'] = $statistics->getTotalCount();
          }
      }

      $iframe = '';
      if($post_format == 'video' || $post_format == 'audio'){
         try{
            $field_post_embed = $node->get('field_post_embed');
            if(isset($field_post_embed->value) && $field_post_embed->value){
               $autoembed = new AutoEmbed();
               $iframe = $autoembed->parse($field_post_embed->value);
            }else{
               $iframe = '';
               $post_format = 'standard';
            }
         }
         catch(Exception $e){
            $post_format = 'standard';
         }
      }
      $variables['gva_iframe'] = $iframe;
      $variables['post_format'] = $post_format;

      if ($variables['node']->getType() == 'bookcase') {
        $base_path = Url::fromRoute('<front>', [], ['absolute' => TRUE])->toString();
        $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();
        $variables['nid'] = $node->id();
        $variables['nodes'] = \Drupal::entityQuery('node')
          ->condition('type', 'bookcase')->condition('langcode', $langcode)
          ->sort('created', 'DESC')->execute();
        $i = 0;
        $position = 0;
        $arrnode = [];
        $variables['arrtitle'] = [];
        $variables['urlNewArticle'] = [];
        foreach ($variables['nodes'] as $key => $value) {
          $arrnode[$i] = $value;
          if ($value == $variables['nid']) {
            $position = $i;
          }
          $i++;
        }
        $i=0;
        $variables['nodesArticle'] =  \Drupal\node\Entity\Node::loadMultiple($variables['nodes']);
        foreach ($variables['nodesArticle'] as $key => $value) {
          $value = $value->getTranslation($langcode);
          $variables['urlNewArticle'][$i] = $value->toUrl();
          $variables['arrtitle'][$i] = $value->label();
          $i++;
        }
        if ($position > 0) {
          $variables['idaf'] = $base_path.\Drupal::service('path_alias.manager')->getAliasByPath('/node/'.$arrnode[$position - 1]);
          $variables['titleaf'] = $variables['arrtitle'][$position - 1];
        }
        if ($position < count($arrnode) -1 ) {
          $variables['idbf'] = $base_path.\Drupal::service('path_alias.manager')->getAliasByPath('/node/'.$arrnode[$position + 1]);
          $variables['titlebf'] = $variables['arrtitle'][$position + 1];
        }

      }
  }
}

function gavias_comely_preprocess_node__portfolio(&$variables){
  $node = $variables['node'];
  
  // Override lesson list on single course
  $output = '';
  $count_information = 0;
  if($node->hasField('field_portfolio_information')){
    $informations = $node->get('field_portfolio_information');
    $count_information = count($informations);
    foreach ($informations as $key => $information) {
      $texts = preg_split('/--/', $information->value);
        $information_text = '';
        foreach ($texts as $k => $text) {
          $information_text .= '<span>' . $text . '</span>';
        }
      $output .= '<div class="item-information">' . $information_text . '</div>';
    }
  }
  $variables['count_information'] = $count_information;
  $variables['informations'] = $output;
}

function gavias_comely_preprocess_node__gallery(&$variables){
  $variables['#attached']['library'][] = 'gavias_comely/gavias_comely.gallery';
}


function gavias_comely_preprocess_breadcrumb(&$variables){
  $variables['#cache']['max-age'] = 0;
  
  $request = \Drupal::request();
  $title = '';
  if ($route = $request->attributes->get(\Symfony\Cmf\Component\Routing\RouteObjectInterface::ROUTE_OBJECT)) {
    $title = \Drupal::service('title_resolver')->getTitle($request, $route);
  }

  if($variables['breadcrumb']){
     foreach ($variables['breadcrumb'] as $key => &$value) {
      if($value['text'] == 'Node'){
        unset($variables['breadcrumb'][$key]);
      }
    }

    if(!empty($title)){
      $variables['breadcrumb'][] = array(
        'text' => ''
      );
      $variables['breadcrumb'][] = array(
        'text' => $title
      );  
    }  
  }
}