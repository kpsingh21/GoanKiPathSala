<?php
namespace Drupal\user_mapping\Controller;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;

class DashboardInfo extends ControllerBase {

  protected $entityTypeManager;

  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  public function info() {

    $query = $this->entityTypeManager->getStorage('node')->getQuery();

    $count = $query
      ->condition('type', 'student')
      ->condition('status', 1)
      ->count()
      ->accessCheck(FALSE)
      ->execute();

    $girls_count = $this->entityTypeManager
      ->getStorage('node')
      ->getQuery()
      ->condition('type', 'student')
      ->condition('status', 1)
      ->condition('field_gender', 'female')
      ->count()
      ->accessCheck(FALSE)
      ->execute();

      $boys_count = $this->entityTypeManager
      ->getStorage('node')
      ->getQuery()
      ->condition('type', 'student')
      ->condition('status', 1)
      ->condition('field_gender', 'male')
      ->count()
      ->accessCheck(FALSE)
      ->execute();

    return [
      '#markup' => "Total: $count | Girls: $girls_count | Boys: $boys_count",
    ];
  }
}
