<?php

namespace Glory\Bundle\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleCategory
 *
 * @ORM\Table(name="article_category", uniqueConstraints={@ORM\UniqueConstraint(name="code", columns={"code"})})
 * @ORM\Entity
 */
class ArticleCategory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=64, nullable=false)
     */
    private $code;

    /**
     * @var integer
     *
     * @ORM\Column(name="weight", type="integer", nullable=false)
     */
    private $weight = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="publishArticle", type="boolean", nullable=false)
     */
    private $publisharticle = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="seoTitle", type="string", length=1024, nullable=false)
     */
    private $seotitle = '';

    /**
     * @var string
     *
     * @ORM\Column(name="seoKeyword", type="string", length=1024, nullable=false)
     */
    private $seokeyword = '';

    /**
     * @var string
     *
     * @ORM\Column(name="seoDesc", type="string", length=1024, nullable=false)
     */
    private $seodesc = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="published", type="boolean", nullable=false)
     */
    private $published = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="parentId", type="integer", nullable=false)
     */
    private $parentid = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="createdTime", type="integer", nullable=false)
     */
    private $createdtime = '0';


}

