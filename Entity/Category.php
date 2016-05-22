<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <https://foreverglory.me/>
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
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", nullable=false)
     */
    protected $label;

    /**
     * @var integer
     *
     * @ORM\Column(name="weight", type="integer", nullable=false)
     */
    protected $weight;

    /**
     * Parent
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $parent = null;

    /**
     * Children
     *
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent", cascade={"all"})
     */
    protected $children = array();

}
