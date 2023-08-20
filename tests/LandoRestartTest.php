<?php

use PHPUnit\Framework\TestCase;
use Robo\TaskAccessor;

class LandoRestartTest extends TestCase
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

  public function testYesNotByDefault()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoRestart())->getCommand();
    $this->assertEquals($this->executable . ' restart', $command);
  }

  public function testFromAnAppDir()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoRestart())->application("my-app")->getCommand();
    $this->assertEquals($this->executable . ' restart my-app', $command);
  }

}
