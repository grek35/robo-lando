<?php

use PHPUnit\Framework\TestCase;
use Robo\TaskAccessor;

class LandoLogsTest extends TestCase
{
  use TaskAccessor;

  protected $executable;

  /**
   * Set up the Robo container so that we can create tasks in our tests.
   */
  function setup(): void
  {
    $executable_finder = new \Symfony\Component\Process\ExecutableFinder();
    $this->executable = $executable_finder->find("lando");
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
