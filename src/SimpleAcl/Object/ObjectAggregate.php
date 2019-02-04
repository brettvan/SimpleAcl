<?php
namespace SimpleAcl\Object;

use SimpleAcl\BaseObject;

/**
 * Implement common function for Role and Resources.
 *
 * @package SimpleAcl\BaseObject
 */
abstract class ObjectAggregate
{
  /**
   * @var Object[]
   */
  protected $objects = array();

  protected function removeObjects()
  {
    $this->objects = array();
  }

  /**
   * @param Object|string $objectName
   *
   * @return bool
   */
  protected function removeObject($objectName)
  {
    if ($objectName instanceof BaseObject) {
      $objectName = $objectName->getName();
    }

    foreach ($this->objects as $objectIndex => $object) {
      if ($object->getName() === $objectName) {
        unset($this->objects[$objectIndex]);

        return true;
      }
    }

    return false;
  }

  /**
   * @return array|Object[]
   */
  protected function getObjects()
  {
    return $this->objects;
  }

  /**
   * @param array $objects
   */
  protected function setObjects($objects)
  {
    /** @var \SimpleAcl\BaseObject $object */
    foreach ($objects as $object) {
      $this->addObject($object);
    }
  }

  /**
   * @param \SimpleAcl\BaseObject $object
   */
  protected function addObject(BaseObject $object)
  {
    if ($this->getObject($object)) {
      return;
    }

    $this->objects[] = $object;
  }

  /**
   * @param Object|string $objectName
   *
   * @return null|Object
   */
  protected function getObject($objectName)
  {
    if ($objectName instanceof BaseObject) {
      $objectName = $objectName->getName();
    }

    foreach ($this->objects as $object) {
      if ($object->getName() === $objectName) {
        return $object;
      }
    }

    return null;
  }

  /**
   * @return array
   */
  protected function getObjectNames()
  {
    // Added sortability due to lack of encapsulation, and the last one wins so I
    // had to make some determination to enforce application logic order
    $names = array();
    $pnames = array();
    $sortable = false;

    foreach ($this->objects as $object) {    
      if (method_exists($object, 'getPriority')) {
        $sortable = true;
        $n = array();
        $n['name'] = $object->getName();
        $n['priority'] = $object->getPriority();
        $pnames[] = $n;
      } else {
          $names[] = $object->getName();
      }
    }
    if ($sortable) {
      usort($pnames, function ($a, $b) {
        return $a['priority'] <=> $b['priority'];
      });
      foreach ($pnames as $pn) {
        $names[]= $pn['name'];
      }
    }
    return $names;
  }
}
