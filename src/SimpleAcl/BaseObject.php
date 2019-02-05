<?php
namespace SimpleAcl;

use IteratorAggregate;
use SimpleAcl\Object\RecursiveIterator;

/**
 * Use to keep shared function between Roles and Resources.
 *
 * @package SimpleAcl
 */
abstract class BaseObject implements IteratorAggregate
{
  /**
   * Hold the name of object.
   *
   * @var string
   */
  protected $name;
  protected $priority;

  /**
   * Create Object with given name.
   *
   * @param string $name
   */
  public function __construct($name, $priority = 0)
  {
    $this->setName($name);
    $this->setPriority($priority);
  }

  /**
   * @return RecursiveIterator
   */
  public function getIterator()
  {
    return new RecursiveIterator(array($this));
  }

  /**
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * @param string $name
   */
  public function setName($name)
  {
    $this->name = $name;
  }

  public function setPriority($priority)
  {
    $this->priority = $priority;
  }

  public function getPriority()
  {
    return $this->priority;
  }
}
