<?php

use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\NullOutput;
use Robo\TaskAccessor;
use Robo\Robo;

class LandoInitTest extends TestCase implements ContainerAwareInterface
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

  public function testYesIsAssumed()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoInit())->getCommand();
    $this->assertEquals($this->executable . ' init --yes', $command);
  }

  public function testAbsenceOfYes()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoInit())->yes(false)->getCommand();
    $this->assertEquals($this->executable . ' init', $command);
  }

  public function testRecipe()
  {
    $command = (new \TheReference\Robo\Task\Lando\LandoInit())->recipe('drupal8')->getCommand();
    $this->assertEquals($this->executable . ' init --recipe drupal8 --yes', $command);
  }

  public function testGithubAuth()
  {
    $this->assertEquals($this->executable . ' init --github-auth loremipsum --yes',
      (new \TheReference\Robo\Task\Lando\LandoInit())->githubAuth('loremipsum')->getCommand());
  }

  public function testGithubRepo()
  {
    $this->assertEquals($this->executable . ' init --github-repo loremipsum --yes',
      (new \TheReference\Robo\Task\Lando\LandoInit())->githubRepo('loremipsum')->getCommand());
  }

  public function testPantheonAuth()
  {
    $this->assertEquals($this->executable . ' init --pantheon-auth loremipsum --yes',
      (new \TheReference\Robo\Task\Lando\LandoInit())->pantheonAuth('loremipsum')->getCommand());
  }

  public function testPantheonSite()
  {
    $this->assertEquals($this->executable . ' init --pantheon-site loremipsum --yes',
      (new \TheReference\Robo\Task\Lando\LandoInit())->pantheonSite('loremipsum')->getCommand());
  }

  public function testDestination()
  {
    $this->assertEquals($this->executable . ' init --destination loremipsum --yes',
      (new \TheReference\Robo\Task\Lando\LandoInit())->destination('loremipsum')->getCommand());
  }

  public function testWebroot()
  {
    $this->assertEquals($this->executable . ' init --webroot loremipsum --yes',
      (new \TheReference\Robo\Task\Lando\LandoInit())->webroot('loremipsum')->getCommand());
  }

  public function testName()
  {
    $this->assertEquals($this->executable . ' init --name loremipsum --yes',
      (new \TheReference\Robo\Task\Lando\LandoInit())->name('loremipsum')->getCommand());
  }
}
