<!-- <?php

namespace Drupal\user_mapping\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Define the Dashboard Info
 */

class DashboardInfo-info extends ControllerBase {


    /**
     * @return array
     */

     public function info(){


        $dashboard_info = [];
        $content_type = 'student';
        $nodes = \Drupal::entityTypeManager()
                ->getStorage('node')
                ->loadByProperties(['type'=>$content_type,'status'=>1]);

                $nodeStorage = \Drupal::entityTypeManager()->getStorage('node');


        // $count = $nodes->getQuery()
        //          ->accessCheck(FALSE)
        //          ->count()
        //          ->execute();

        $count = \Drupal::entityQuery('node')
  ->condition('type', $content_type)
  ->condition('status', 1)
  ->count()
  ->accessCheck(FALSE)
  ->execute();


  $girls_count = \Drupal::entityQuery('node')
  ->condition('type', 'student')
  ->condition('status', 1)
  ->condition('field_gender', 'female')
  ->count()
  ->accessCheck(FALSE)
  ->execute();


                 dd($nodes,$nodeStorage,$count,$girls_count);



    }
} -->