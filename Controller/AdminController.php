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
        $form = $this->createForm('glory_category_form', $category);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager->updateCategory($category);
            return $this->redirectToRoute('glory_category_show', ['id' => $category->getId()]);
        }
        return $this->render('GloryCategoryBundle:Admin:create.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function showAction(Request $request, $id)
    {
        $category = $this->getCategoryOrThrow($id);
        return $this->render('GloryCategoryBundle:Admin:show.html.twig', ['category' => $category]);
    }

    public function editAction(Request $request, $id)
    {
        $manager = $this->get('glory_category.category_manager');
        $category = $this->getCategoryOrThrow($id);

        $form = $this->createForm('glory_category_form', $category);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager->updateCategory($category);
            if ($category->isRoot()) {
                return $this->redirectToRoute('glory_category');
            }
            return $this->redirectToRoute('glory_category_show', ['id' => $category->getRoot()->getId()]);
        }
        return $this->render('GloryCategoryBundle:Admin:edit.html.twig', [
                    'form' => $form->createView(),
                    'category' => $category
        ]);
    }

    public function deleteAction(Request $request, $id)
    {
        $manager = $this->get('glory_category.category_manager');
        $category = $this->getCategoryOrThrow($id);

        if ($category->isRoot()) {
            $url = $this->generateUrl('glory_category');
        } else {
            $url = $this->generateUrl('glory_category_show', ['id' => $category->getRoot()->getId()]);
        }
        if ($category->hasChildren()) {
            $message = sprintf('Category %s has children, You need to delete the subtypes.', $category->getName());
            $this->addFlash('warning', $message);
        } else {
            $message = sprintf('Category %s deleted.', $category->getName());
            $manager->deleteCategory($category);
            $this->addFlash('success', $message);
        }
        return $this->redirect($url);
    }

    protected function getCategoryOrThrow($id)
    {
        $manager = $this->get('glory_category.category_manager');
        $category = $manager->findCategory($id);
        if (!$category) {
            throw $this->createNotFoundException('Category is not exist.');
        }
        return $category;
    }

}
