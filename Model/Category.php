<?php

namespace Glory\Bundle\CategoryBundle\Model;

/**
 * Category
 */
class Category
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $parent;

    /**
     * @var string 
     */
    protected $type;

    /**
     * @var integer
     */
    protected $weight;

    /**
     * @var array 
     */
    protected $children;

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function addChild($child)
    {
        
    }

    public function removeChild($child)
    {
        
    }

    public function getChildren()
    {
        return $this->children;
    }

}
