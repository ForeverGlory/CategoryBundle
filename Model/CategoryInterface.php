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
 * CategoryInterface
 * 
 * @author ForeverGlory <foreverglory@qq.com>
 */
interface CategoryInterface
{

    public function setId($id);

    public function getId();

    public function setName($name);

    public function getName();

    public function setParent(CategoryInterface $category);

    public function getParent();

    public function setWeight($weight);

    public function getWeight();

    public function addChild(CategoryInterface $category);

    public function hasChild($name);

    public function removeChild($name);

    public function getChildren();
    
    public function isRoot();
    
    public function getRoot();
    
    public function getLevel();
}
