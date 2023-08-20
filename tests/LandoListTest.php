<?php

use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\NullOutput;
use Robo\TaskAccessor;
use Robo\Robo;

class LandoListTest extends TestCase
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
    $command = (new \TheReference\Robo\Task\Lando\LandoList())->getCommand();
    $this->assertEquals($this->executable . ' list', $command);
  }

  public function testYesWhenForcing()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoList())->yes(true)->getCommand();
    $this->assertEquals($this->executable . ' list --yes', $command);
  }

}
