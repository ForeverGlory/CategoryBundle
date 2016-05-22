<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <https://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\CategoryBundle\Model;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Glory\Bundle\CategoryBundle\Model\CategoryInterface;

/**
 * Description of CategoryManager
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class CategoryManager
{

    protected $container;
    protected $class;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * set Class
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * get Class
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * 创建
     * 
     * @return CategoryInterface
     */
    public function createCategory()
    {
        $class = $this->getClass();
        $category = new $class();
        return $category;
    }

    /**
     * 查找
     * 
     * @param array $criteria
     * @return CategoryInterface
     */
    public function findCategory($criteria)
    {
        $repository = $this->getDoctrine()->getRepository($this->getClass());
        return $repository->findOneBy($criteria);
    }

    /**
     * 查找's
     * 
     * @param array $criteria
     * @param array $orderBy
     * @param type $limit
     * @param type $offset
     * @return array|null
     */
    public function findCategories(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $repository = $this->getDoctrine()->getRepository($this->getClass());
        return $repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * 更新
     * 
     * @param CategoryInterface $category
     * @param type $andFlush
     */
    public function updateCategory(CategoryInterface $category, $andFlush = true)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        if ($andFlush) {
            $em->flush();
        }
    }

    /**
     * 删除
     * 
     * @param CategoryInterface $category
     */
    public function deleteCategory(CategoryInterface $category)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
    }

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    protected function getDoctrine()
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }

}
