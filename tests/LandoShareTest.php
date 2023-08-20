<?php

use PHPUnit\Framework\TestCase;
use Robo\TaskAccessor;

class LandoShareTest extends TestCase
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
    $command = (new \TheReference\Robo\Task\Lando\LandoShare())->getCommand();
    $this->assertEquals($this->executable . ' share', $command);
  }

  public function testFromAnAppDir()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoShare())->url("http://localhost:32785")->getCommand();
    $this->assertEquals($this->executable . " share --url 'http://localhost:32785'", $command);
  }

}
