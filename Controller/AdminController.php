<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\CategoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of AdminController
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class AdminController extends Controller
{

    public function indexAction(Request $request)
    {
        $types = $this->get('glory_category.category_manager')->findCategories(['parent' => null]);
        return $this->render('GloryCategoryBundle:Admin:index.html.twig', ['types' => $types]);
    }

    public function createAction(Request $request)
    {
        $manager = $this->get('glory_category.category_manager');
        $category = $manager->createCategory();
        $form = $this->createForm('glory_category_type_form', $category);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager->updateCategory($category);
            return $this->redirectToRoute('glory_category_show', ['id' => $category->getId()]);
        }
        return $this->render('GloryCategoryBundle:Admin:create.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function showAction(Request $request)
    {
        
    }

    public function editAction(Request $request, $id)
    {
        
    }

    public function deleteAction(Request $request)
    {
        
    }

}
