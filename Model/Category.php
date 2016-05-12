<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\CategoryBundle\Model;

/**
 * Category
 * 
 * @author ForeverGlory <foreverglory@qq.com>
 */
class Category implements CategoryInterface
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

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setParent(CategoryInterface $category)
    {
        $this->parent = $category;
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

    public function addChild(CategoryInterface $category)
    {
        $this->children[$category->getName()] = $category;
        return $this;
    }

    public function hasChild($name)
    {
        return array_key_exists($name, $this->children);
    }

    public function removeChild($name)
    {
        if ($this->hasChild($name)) {
            unset($this->children[$name]);
        }
        return $this;
    }

    public function getChildren()
    {
        return $this->children;
    }

}
