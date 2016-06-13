<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\CategoryBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Glory\Bundle\CategoryBundle\Model\CategoryInterface;

/**
 * Description of Category Weight Listener
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class CategoryWeightListener implements EventSubscriber
{

    public function __construct()
    {
        
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::preUpdate,
            Events::postUpdate
        );
    }

    private $preCategory = [];

    public function preUpdate(LifecycleEventArgs $args)
    {
        $object = $args->getObject();
        if ($object instanceof CategoryInterface && !$object->isRoot()) {
            //todo: get preCategory
            //$category = ...
            //$this->setPreCategory($category);
        }
    }

    public function setPreCategory(CategoryInterface $category)
    {
        $this->preCategory = $category;
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $object = $args->getObject();
        if ($object instanceof CategoryInterface && $this->preCategory && !$object->isRoot()) {
            $em = $args->getObjectManager();
            if ($object->getParent()->getId() == $this->preCategory->getParent()->getId()) {
                $qb = $em->createQueryBuilder()
                        ->update(get_class($object), 'category');
                if ($object->getWeight() > $this->preCategory->getWeight()) {
                    $qb->set('category.weight', 'category.weight - 1')
                            ->where('category.id != :id and category.parent = :parent and category.weight >= :min and category.weight <= :max')
                            ->setParameter('id', $object->getId())
                            ->setParameter('parent', $object->getParent())
                            ->setParameter('min', $this->preCategory->getWeight() + 1)
                            ->setParameter('max', $object->getWeight())
                    ;
                    $qb->getQuery()->execute();
                } elseif ($object->getWeight() < $this->preCategory->getWeight()) {
                    $qb->set('category.weight', 'category.weight + 1')
                            ->where('category.id != :id and category.parent = :parent and category.weight >= :min and category.weight <= :max')
                            ->setParameter('id', $object->getId())
                            ->setParameter('parent', $object->getParent())
                            ->setParameter('min', $object->getWeight())
                            ->setParameter('max', $this->preCategory->getWeight() - 1)
                    ;
                    $qb->getQuery()->execute();
                }
            } else {
                //pre
                $qb = $em->createQueryBuilder()
                        ->update(get_class($object), 'category')
                        ->set('category.weight', 'category.weight - 1')
                        ->where('category.id != :id and category.parent = :parent and category.weight > :weight')
                        ->setParameter('id', $object->getId())
                        ->setParameter('parent', $this->preCategory->getParent())
                        ->setParameter('weight', $this->preCategory->getWeight())
                ;
                $qb->getQuery()->execute();
                //new
                $qb = $em->createQueryBuilder()
                        ->update(get_class($object), 'category')
                        ->set('category.weight', 'category.weight + 1')
                        ->where('category.id != :id and category.parent = :parent and category.weight >= :weight')
                        ->setParameter('id', $object->getId())
                        ->setParameter('parent', $object->getParent())
                        ->setParameter('weight', $object->getWeight())
                        ->setParameter('id', $object->getId())
                ;
                $qb->getQuery()->execute();
            }
        }
    }

}
