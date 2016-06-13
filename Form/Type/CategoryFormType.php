<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\CategoryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Glory\Bundle\CategoryBundle\Model\CategoryManager;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Description of ContentType
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class CategoryFormType extends AbstractType
{

    /**
     * @var CategoryManager 
     */
    protected $categoryManager;

    public function __construct(CategoryManager $catgoryManager)
    {
        $this->categoryManager = $catgoryManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['data']->isRoot()) {
            $builder
                    ->add('name')
            ;
        } else {
            $builder
                    ->add('name')
                    ->add('parent', 'category', array(
                        'class' => $this->categoryManager->getClass(),
                        'property' => 'label',
                        'level_property' => 'level',
                        'parent_property' => 'parent'
                    ))
            ;
        }
        $builder->add('save', SubmitType::class);
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        
    }

    public function getName()
    {
        return 'glory_category_form';
    }

}
