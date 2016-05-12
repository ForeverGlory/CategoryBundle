<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\CategoryBundle\Entity;

use Glory\Bundle\CategoryBundle\Model\Category as BaseCategory;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category Entity
 *
 * @ORM\MappedSuperclass
 * @author ForeverGlory <foreverglory@qq.com>
 */
class Category extends BaseCategory
{

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=64, nullable=false)
     */
    protected $code;

    /**
     * @var integer
     *
     * @ORM\Column(name="weight", type="integer", nullable=false)
     */
    protected $weight;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="id")
     */
    protected $parent;

}
