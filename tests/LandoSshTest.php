<?php

use PHPUnit\Framework\TestCase;
use Robo\TaskAccessor;

class LandoSshTest extends TestCase
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
    $command = (new \TheReference\Robo\Task\Lando\LandoSsh())->getCommand();
    $this->assertEquals($this->executable . ' ssh', $command);
  }

  public function testFromAppdirToService()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoSsh())->service("appserver")->getCommand();
    $this->assertEquals($this->executable . " ssh appserver", $command);
  }

  public function testFromAppAndService()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoSsh())->application("myapp")->service("database")->getCommand();
    $this->assertEquals($this->executable . " ssh myapp database", $command);
  }

  public function testListAllFilesInRootOfAppserver()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoSsh())->service("appserver")->command("ls -ls /")->getCommand();
    $this->assertEquals($this->executable . " ssh appserver --command 'ls -ls /'", $command);
  }

}
