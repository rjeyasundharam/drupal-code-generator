<?php declare(strict_types = 1);

namespace Drupal\Tests\foo\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Test description.
 *
 * @group foo
 */
final class ExampleTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['foo'];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    // Mock necessary services here.
  }

  /**
   * Test callback.
   */
  public function testSomething(): void {
    self::assertTrue(TRUE);
  }

}
