<?php

use PHPUnit\Framework\TestCase;
use Robo\TaskAccessor;

class LandoInitTest extends TestCase
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
