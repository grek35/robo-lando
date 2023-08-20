<?php

use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\NullOutput;
use Robo\TaskAccessor;
use Robo\Robo;

class LandoPoweroffTest extends TestCase implements ContainerAwareInterface
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

  public function testNoYesByDefault()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoPoweroff())->getCommand();
    $this->assertEquals($this->executable . ' poweroff', $command);
  }

  public function testYesWhenForcing()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoPoweroff())->yes(true)->getCommand();
    $this->assertEquals($this->executable . ' poweroff --yes', $command);
  }

}
