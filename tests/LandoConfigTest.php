<?php

use PHPUnit\Framework\TestCase;
use Robo\TaskAccessor;

class LandoConfigTest extends TestCase
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

  public function testNoYesByDefault()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoConfig())->getCommand();
    $this->assertEquals($this->executable . ' config', $command);
  }

  public function testYesWhenForcing()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoConfig())->yes(true)->getCommand();
    $this->assertEquals($this->executable . ' config --yes', $command);
  }

}
