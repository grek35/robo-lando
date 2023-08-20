<?php

use PHPUnit\Framework\TestCase;
use Robo\TaskAccessor;

class LandoRebuildTest extends TestCase
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
