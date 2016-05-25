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

    public function listAction(Request $request)
    {
        
    }

    public function createAction(Request $request)
    {
        $manager = $this->get('glory_category.category_manager');
        $category = $manager->createCategory();
        $form = $this->createForm('glory_category_form', $category);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager->updateCategory($category);
        }
        return $this->render('GloryCategoryBundle:Admin:create.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function showAction(Request $request)
    {
        
    }

    public function editAction(Request $request)
    {
        
    }

    public function deleteAction(Request $request)
    {
        
    }

}
