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
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Glory\Bundle\CategoryBundle\Model\CategoryInterface;

/**
 * Description of Category Weight Listener
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class CategoryWeightListener implements EventSubscriber
{

    private $preCategory = [];

    public function __construct()
    {
        
    }

    public function getSubscribedEvents()
    {
        //Events::prePersist -> Events::preFlush -> Events::postPersist -> Events::postFlush
        //Events::preFlush -> Events::preUpdate -> Events::postUpdate -> Events::postFlush
        return array(
            Events::prePersist,
            Events::postPersist,
            Events::preUpdate,
            Events::postUpdate,
            Events::preFlush,
            Events::postFlush,
        );
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $object = $args->getObject();
        if ($object instanceof CategoryInterface) {
            if ($args->hasChangedField('parent')) {
                $this->preCategory['parent'] = $args->getOldValue('parent');
            }
            if ($args->hasChangedField('weight')) {
                $this->preCategory['weight'] = intval($args->getOldValue('weight'));
            }
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $object = $args->getObject();
        if ($object instanceof CategoryInterface && $this->preCategory) {
            $em = $args->getObjectManager();
            if (empty($this->preCategory['parent']) || $object->getParent()->getId() == $this->preCategory['parent']->getId()) {
                $qb = $em->createQueryBuilder()
                        ->update(get_class($object), 'category');
                if ($object->getWeight() > $this->preCategory['weight']) {
                    $qb->set('category.weight', 'category.weight - 1')
                            ->where('category.id != :id and category.parent = :parent and category.weight >= :min and category.weight <= :max')
                            ->setParameter('id', $object->getId())
                            ->setParameter('parent', $object->getParent())
                            ->setParameter('min', $this->preCategory['weight'] + 1)
                            ->setParameter('max', $object->getWeight())
                    ;
                    $qb->getQuery()->execute();
                } elseif ($object->getWeight() < $this->preCategory['weight']) {
                    $qb->set('category.weight', 'category.weight + 1')
                            ->where('category.id != :id and category.parent = :parent and category.weight >= :min and category.weight <= :max')
                            ->setParameter('id', $object->getId())
                            ->setParameter('parent', $object->getParent())
                            ->setParameter('min', $object->getWeight())
                            ->setParameter('max', $this->preCategory['weight'] - 1)
                    ;
                    $qb->getQuery()->execute();
                }
            } elseif ($object->getParent()->getId() != $this->preCategory['parent']->getId()) {
                //pre
                $qb = $em->createQueryBuilder()
                        ->update(get_class($object), 'category')
                        ->set('category.weight', 'category.weight - 1')
                        ->where('category.id != :id and category.parent = :parent and category.weight > :weight')
                        ->setParameter('id', $object->getId())
                        ->setParameter('parent', $this->preCategory['parent'])
                        ->setParameter('weight', $this->preCategory['weight'])
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
            $this->preCategory = [];
        }
    }

    public function preFlush(PreFlushEventArgs $args)
    {
        
    }

    public function postFlush(PostFlushEventArgs $args)
    {
        
    }

}
