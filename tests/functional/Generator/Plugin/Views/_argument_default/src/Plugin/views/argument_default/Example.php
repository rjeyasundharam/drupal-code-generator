<?php declare(strict_types = 1);

namespace Drupal\foo\Plugin\views\argument_default;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Cache\CacheableDependencyInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\views\Plugin\views\argument_default\ArgumentDefaultPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @todo Add plugin description here.
 *
 * @ViewsArgumentDefault(
 *   id = "foo_example",
 *   title = @Translation("Example"),
 * )
 */
final class Example extends ArgumentDefaultPluginBase implements CacheableDependencyInterface {

  /**
   * Constructs a new Example instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    private readonly RouteMatchInterface $routeMatch,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self {
    return new self(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_route_match'),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions(): array {
    $options = parent::defineOptions();
    $options['example'] = ['default' => ''];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state): void {
    $form['example'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Example'),
      '#default_value' => $this->options['example'],
    ];
  }

  /**
   * {@inheritdoc}
   *
   * @todo Make sure the return type-hint matches the argument type.
   */
  public function getArgument(): int {

    // @DCG
    // Here is the place where you should create a default argument for the
    // contextual filter. The source of this argument depends on your needs.
    // For example, the argument can be extracted from the URL or fetched from
    // some fields of the currently viewed entity.
    $argument = 123;

    return $argument;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge(): int {
    return Cache::PERMANENT;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts(): array {
    // @todo Use 'url.path' or 'url.query_args:%key' contexts if the argument
    // comes from URL.
    return [];
  }

}
