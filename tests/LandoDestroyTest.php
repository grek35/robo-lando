<?php

use PHPUnit\Framework\TestCase;
use Robo\TaskAccessor;

class LandoDestroyTest extends TestCase
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

  public function testYesIsAssumed()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoDestroy())->getCommand();
    $this->assertEquals($this->executable . ' destroy --yes', $command);
  }

  public function testAbsenceOfYes()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoDestroy())->yes(false)->getCommand();
    $this->assertEquals($this->executable . ' destroy', $command);
  }

  public function testApplication()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoDestroy())->application('loremipsum')->getCommand();
    $this->assertEquals($this->executable . ' destroy loremipsum --yes', $command);
  }

}
