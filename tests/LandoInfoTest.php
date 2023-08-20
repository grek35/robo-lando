<?php

use PHPUnit\Framework\TestCase;
use Robo\TaskAccessor;

class LandoInfoTest extends TestCase
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
