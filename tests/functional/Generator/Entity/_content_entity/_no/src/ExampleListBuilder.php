<?php declare(strict_types = 1);

namespace Drupal\foo;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for the example entity type.
 */
final class ExampleListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['id'] = $this->t('ID');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    /** @var \Drupal\foo\ExampleInterface $entity */
    $row['id'] = $entity->id();
    return $row + parent::buildRow($entity);
  }

}
