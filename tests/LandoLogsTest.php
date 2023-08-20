<?php

use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\NullOutput;
use Robo\TaskAccessor;
use Robo\Robo;

class LandoLogsTest extends TestCase implements ContainerAwareInterface
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

  public function testYesIsNotAnOption()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoLogs())->getCommand();
    $this->assertEquals($this->executable . ' logs', $command);
  }

  public function testApp()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoLogs())->application("my-app")->getCommand();
    $this->assertEquals($this->executable . ' logs my-app', $command);
  }

  public function testTimeStampAndFollow()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoLogs())->timestamps()->follow()->getCommand();
    $this->assertEquals($this->executable . ' logs --timestamps --follow', $command);
  }

  public function testShowMultipleServices()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoLogs())->services(array("database", "cache"))->getCommand();
    $this->assertEquals($this->executable . ' logs --services database --services cache', $command);
  }

}
