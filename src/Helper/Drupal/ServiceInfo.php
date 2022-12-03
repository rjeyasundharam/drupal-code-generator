<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Helper\Drupal;

use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A helper that provides information about available Drupal services.
 */
final class ServiceInfo extends Helper {

  /**
   * Constructs the helper.
   */
  public function __construct(private readonly ContainerInterface $container) {}

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'service_info';
  }

  /**
   * Gets a service by name.
   */
  public function getService(string $name): ?object {
    return $this->container->get($name);
  }

  /**
   * Gets all defined service IDs.
   */
  public function getServicesIds(): array {
    // $this->container->getServiceIds() cannot be used here because it is not
    // defined in the Symfony\Component\DependencyInjection\ContainerInterface.
    $service_ids = \array_keys($this->getServiceDefinitions());
    \sort($service_ids);
    return $service_ids;
  }

  /**
   * Gets all service definitions.
   */
  public function getServiceDefinitions(): array {
    return \array_map('unserialize', $this->getSerializedDefinitions());
  }

  /**
   * Gets all service definitions.
   */
  public function getServiceClasses(): array {
    $service_definitions = \array_filter(
      $this->getServiceDefinitions(),
      static fn ($definition): bool => \array_key_exists('class', $definition),
    );
    $classes = \array_combine(
      \array_keys($service_definitions),
      \array_column($service_definitions, 'class'),
    );
    return \array_map([Utils::class, 'addLeadingSlash'], $classes);
  }

  /**
   * Gets service definition.
   */
  public function getServiceDefinition(string $service_id): ?array {
    $serialized_definitions = $this->getSerializedDefinitions();
    if (!\array_key_exists($service_id, $serialized_definitions)) {
      return NULL;
    }
    // @phpcs:ignore DrupalPractice.FunctionCalls.InsecureUnserialize.InsecureUnserialize
    return \unserialize($serialized_definitions[$service_id]);
  }

  /**
   * Returns array of serialized service definitions.
   */
  private function getSerializedDefinitions(): array {
    $cache_definitions = $this->container
      ->get('kernel')
      ->getCachedContainerDefinition();
    $serialized_definitions = $cache_definitions['services'] ?? [];
    \ksort($serialized_definitions);
    return $serialized_definitions;
  }

}
