<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserAddressType;
use App\Service\ImageUploadInterface;
use App\Service\UserPaginationInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * @Route("/", name="main")
     */
    public function indexAction(UserPaginationInterface $userPagination)
    {
        return $this->render('user_address/index.html.twig', [
            'users' => $userPagination->get(),
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function addAction(Request $request, ImageUploadInterface $imageUpload)
    {
        $form = $this->createForm(UserAddressType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $newUser */
            $newUser = $form->getData();
            if ($newUser->getUploadedFile()) {
                try {
                    $imagePath = $imageUpload->upload($newUser->getUploadedFile());
                    $newUser->setPicture($imagePath);
                } catch (FileException $exception) {
                    // ... handle exception if something happens during file upload
                }
            }

            $this->getEntityManager()->persist($newUser);
            $this->getEntityManager()->flush();

            $this->addFlash('success', 'Address added successfully!');

            return $this->redirectToRoute('main');

        } elseif ($form->isSubmitted() && $form->isValid() === false) {
            $this->addFlash('danger', 'Please enter valid data');
        }

        return $this->render('user_address/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", requirements={"id"="\d+"})
     */
    public function editAction(Request $request, User $user, ImageUploadInterface $imageUpload)
    {
        $form = $this->createForm(UserAddressType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form->get('uploadedFile')->getData();
            if ($uploadedFile) {
                try {
                    $this->delete($user->getPicture());
                    $imagePath = $imageUpload->upload($uploadedFile);
                    $user->setPicture($imagePath);
                } catch (FileException $exception) {
                    // ... handle exception if something happens during file upload
                }
            }

            $this->getEntityManager()->flush();

            $this->addFlash('success', 'Address edited successfully!');

            return $this->redirectToRoute('main');

        } elseif ($form->isSubmitted() && $form->isValid() === false) {
            $this->addFlash('danger', 'Please enter valid data');
        }

        return $this->render('user_address/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", requirements={"id"="\d+"})
     */
    public function deleteAction(User $user)
    {
        $this->delete($user->getPicture());
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
        $this->addFlash('success', 'Address deleted successfully!');

        return $this->redirectToRoute('main');
    }

    private function getEntityManager(): ObjectManager
    {
        return $this->getDoctrine()->getManager();
    }

    private function delete($filename)
    {
        if ($filename) {
            unlink($this->getParameter('upload_directory').$filename);
        }
    }
}
