<?php

use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\NullOutput;
use Robo\TaskAccessor;
use Robo\Robo;

class LandoSshTest extends TestCase implements ContainerAwareInterface
{
  use TaskAccessor;
  use ContainerAwareTrait;

  protected $executable;

  /**
   * Set up the Robo container so that we can create tasks in our tests.
   */
  function setup(): void
  {
    $container = Robo::createDefaultContainer(null, new NullOutput());
    $this->setContainer($container);
    $executable_finder = new \Symfony\Component\Process\ExecutableFinder();
    $this->executable = $executable_finder->find("lando");
  }

  /**
   * Scaffold the collection builder
   */
  public function collectionBuilder()
  {
    $emptyRobofile = new \Robo\Tasks;
    return $this->getContainer()->get('collectionBuilder', [$emptyRobofile]);
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
