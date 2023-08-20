<?php

use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\NullOutput;
use Robo\TaskAccessor;
use Robo\Robo;

class LandoInfoTest extends TestCase implements ContainerAwareInterface
{
  use TaskAccessor;
  use ContainerAwareTrait;

  protected $executable;

  /**
   * Set up the Robo container so that we can create tasks in our tests.
   */
  function setup(): void
  {
    $container = Robo::createDefaultContainer(null, new NullOutput());
    $this->setContainer($container);
    $executable_finder = new \Symfony\Component\Process\ExecutableFinder();
    $this->executable = $executable_finder->find("lando");
  }

  /**
   * Scaffold the collection builder
   */
  public function collectionBuilder()
  {
    $emptyRobofile = new \Robo\Tasks;
    return $this->getContainer()->get('collectionBuilder', [$emptyRobofile]);
  }

  public function testYesIsNotDefault()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoInfo())->getCommand();
    $this->assertEquals($this->executable . ' info', $command);
  }

  public function testForceYes()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoInfo())->yes(true)->getCommand();
    $this->assertEquals($this->executable . ' info --yes', $command);
  }

  public function testDeep()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoInfo())->deep()->getCommand();
    $this->assertEquals($this->executable . ' info --deep', $command);
  }

}
