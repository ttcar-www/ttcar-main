<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Entity\Contact;
use App\Entity\ContactCars;
use App\Entity\Doc;
use App\Form\ContactByCarFormType;
use App\Form\ContactFormType;
use App\Form\DocsFormType;
use App\Service\FileUploader;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class DocController extends AbstractController
{
    /**
     * @Route("/admin/new_doc", name="new_doc")
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function createDoc(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $doc = new Doc();
        $date = new DateTime('@'.strtotime('now'));

        $form = $this->createForm(
            DocsFormType::class,
            $doc);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $DocImg */
            $DocImg = $form->get('DocImg')->getData();

            if ($DocImg) {
                $DocImg = $fileUploader->upload($DocImg);
                $doc->setDocImg($DocImg);
            }

            $doc->setCreateAt($date);

            $entityManager->persist($doc);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Doc enregistré'
            );

            return $this->redirectToRoute('manage_doc');
        }

        return $this->render('form/create_new_doc.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/delete_doc/{id}", name="delete_doc")
     * @param $id
     * @return RedirectResponse
     */
    public function deleteDoc($id, EntityManagerInterface $entityManager): RedirectResponse
    {
        $date = new DateTime('@'.strtotime('now'));

        $repository = $entityManager->getRepository(Doc::class);
        $contact = $repository->find($id);

        $contact->setDeletedAt($date);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Message supprimé'
        );

        return $this->redirectToRoute('manage_doc');
    }

}
