<?php
namespace SimpleAcl\Object;

use RecursiveIterator as SplIterator;
use SimpleAcl\Object;

/**
 * Used to iterate by Roles and Resources hierarchy.
 *
 * @package SimpleAcl\Object
 */
class RecursiveIterator implements SplIterator
{
  /**
   * @var Object[]
   */
  protected $objects = array();

  /**
   * @param $objects
   */
  public function __construct($objects)
  {
    $this->objects = $objects;
  }

  public function current()
  {
    return current($this->objects);
  }

  public function next()
  {
    return next($this->objects);
  }

  public function key()
  {
    if (null === key($this->objects)) {
      return null;
    }

    return $this->current()->getName();
  }

  public function valid()
  {
    return $this->key() !== null;
  }

  public function rewind()
  {
    return reset($this->objects);
  }

  public function hasChildren()
  {
    return false;
  }

  public function getChildren()
  {
    return false;
  }


}
