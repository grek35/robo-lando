<?php

use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\NullOutput;
use Robo\TaskAccessor;
use Robo\Robo;

class LandoListTest extends TestCase implements ContainerAwareInterface
{
  use \TheReference\Robo\Task\Lando\loadTasks;
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

  public function testNoYesByDefault()
  {
    $command = $this->taskLandoList()
      ->getCommand();
    $this->assertEquals($this->executable . ' list', $command);
  }

  public function testYesWhenForcing()
  {
    $command = $this->taskLandoList()->yes(true)->getCommand();
    $this->assertEquals($this->executable . ' list --yes', $command);
  }

}
