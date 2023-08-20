<?php

use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\NullOutput;
use Robo\TaskAccessor;
use Robo\Robo;

class LandoDestroyTest extends TestCase implements ContainerAwareInterface
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

  public function testYesIsAssumed()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoDestroy())->getCommand();
    $this->assertEquals($this->executable . ' destroy --yes', $command);
  }

  public function testAbsenceOfYes()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoDestroy())->yes(false)->getCommand();
    $this->assertEquals($this->executable . ' destroy', $command);
  }

  public function testApplication()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoDestroy())->application('loremipsum')->getCommand();
    $this->assertEquals($this->executable . ' destroy loremipsum --yes', $command);
  }

}
