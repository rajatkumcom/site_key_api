<?php

namespace Drupal\site_api_key_validator\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
* Class CustomRestController.
*/
class SiteApiKeyRestController extends ControllerBase {


  public function __construct() {
  }

  public function getNode( $nid, $key ) {

    if( is_numeric($nid) ) {
      $node = \Drupal\node\Entity\Node::load($nid);
      if( $node ) {
        return new JsonResponse((array)$node);
      } else {
        return new JsonResponse('Node not exist.');
      }
    } else {
      return new JsonResponse('In Valid Nid.');
    }

  }

  public function access( $nid, $key ) {

    $config = \Drupal::config('site_api_key_validator.siteapikey');
    if( 'No API Key yet' != $config->get('siteapikey') && $key == $config->get('siteapikey') ) {
        return AccessResult::allowed();
    }
    return AccessResult::forbidden(new JsonResponse('Key Does\'t match.'));
  }
}