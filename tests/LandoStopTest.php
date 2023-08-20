<?php

use PHPUnit\Framework\TestCase;
use Robo\TaskAccessor;

class LandoStopTest extends TestCase
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
    $command = (new \TheReference\Robo\Task\Lando\LandoStop())->getCommand();
    $this->assertEquals($this->executable . ' stop', $command);
  }

  public function testFromOutsideAppDir()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoStop())->application("myapp")->getCommand();
    $this->assertEquals($this->executable . " stop myapp", $command);
  }

}
