<?php

use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\NullOutput;
use Robo\TaskAccessor;
use Robo\Robo;

class LandoRebuildTest extends TestCase implements ContainerAwareInterface
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

  public function testYesByDefault()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoRebuild())->getCommand();
    $this->assertEquals($this->executable . ' rebuild --yes', $command);
  }

  public function testNoYesWhenForcing()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoRebuild())->yes(false)->getCommand();
    $this->assertEquals($this->executable . ' rebuild', $command);
  }

  public function testFromAnAppDir()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoRebuild())->application("my-app")->getCommand();
    $this->assertEquals($this->executable . ' rebuild my-app --yes', $command);
  }

  public function testMultipleServices()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoRebuild())->services(array("cache", "appserver"))->getCommand();
    $this->assertEquals($this->executable . ' rebuild --services cache --services appserver --yes', $command);
  }

}
