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
use Symfony\Component\HttpFoundation\JsonResponse;
use Glory\Bundle\CategoryBundle\EventListener\CategoryWeightListener;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;


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

    public function editAction(Request $request)
    {
        $manager = $this->get('glory_category.category_manager');

        if ($id = $request->get('id', null)) {
            $category = $this->getCategoryOrThrow($id);
        } else {
            $category = $manager->createCategory();
        }
        if ($parentId = $request->get('parent_id')) {
            $parent = $this->getCategoryOrThrow($parentId);
            $category->setParent($parent);
        }

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

    public function deleteAction(Request $request)
    {
        $manager = $this->get('glory_category.category_manager');
        $category = $this->getCategoryOrThrow($request->get('id'));

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

    public function ajaxAction(Request $request)
    {
        $data = [];
        $manager = $this->get('glory_category.category_manager');
        switch ($request->get('action')) {
            case 'add':
                $parentId = $request->request->get('parent_id');
                $name = $request->request->get('name');
                $weight = $request->request->get('weight', 0);
                $category = $manager->createCategory();

                $parent = $this->getCategoryOrThrow($parentId);
                $category->setName($name);
                $category->setParent($parent);
                $category->setWeight($weight);

                $manager->updateCategory($category);
                $data = ['id' => $category->getId()];
                break;
            case 'rename':
                $category = $this->getCategoryOrThrow($request->get('id'));
                $category->setName($request->request->get('name'));
                $manager->updateCategory($category);
                break;
            case 'move':
                $category = $this->getCategoryOrThrow($request->get('id'));
                $parentId = $request->request->get('parent_id');
                if ($parentId != $category->getParent()->getId()) {
                    $parent = $this->getCategoryOrThrow($parentId);
                    $category->setParent($parent);
                }
                $weight = $request->request->get('weight');
                $category->setWeight($weight);
                $manager->updateCategory($category);
                break;
            case 'delete':
                $this->deleteAction($request);
                break;
            default:
                break;
        }
        return new JsonResponse($data);
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
