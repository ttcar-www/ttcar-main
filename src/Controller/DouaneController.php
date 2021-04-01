<?php

namespace App\Controller;

use App\Entity\ContactDouane;
use App\Form\ContactDouaneFormType;
use Exception;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;


class DouaneController extends AbstractController
{
    /**
     * @Route("/TTdouaneExport/", name="TTdouane")
     * @return Response
     */
    public function index()
    {

        return $this->render('douane/index.html.twig');
    }

    /**
     * @Route("/TTdouaneExport/transit", name="transit")
     * @return Response
     */
    public function transit()
    {

        return $this->render('douane/transit.html.twig');
    }

    /**
     * @Route("/TTdouaneExport/export", name="export")
     * @return Response
     */
    public function export()
    {

        return $this->render('douane/export.html.twig');
    }

    /**
     * @Route("/TTdouaneExport/douane", name="douane")
     * @return Response
     */
    public function douane()
    {

        return $this->render('douane/douane.html.twig');
    }

    /**
     * @Route("/TTdouaneExport/transport", name="transport")
     * @return Response
     */
    public function transport()
    {

        return $this->render('douane/transport.html.twig');
    }

    /**
     * @Route("/TTdouaneExport/contact", name="contactDouane")
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function contact(Request $request)
    {
        $contact = new ContactDouane();
        $date = new \DateTime('@'.strtotime('now'));

        $form = $this->createForm(
            ContactDouaneFormType::class,
            $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $contact->setCreateAt($date);
            $contact->setIsRead(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            //Rajouter FlashBag success

            return $this->redirectToRoute('TTdouane');
        }


        return $this->render('douane/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/manage_contact_douane", name="manage_contact_douane")
     * @return Response
     */
    public function manageContactDouane(): Response
    {
        $contacts = $this->getDoctrine()
            ->getRepository(ContactDouane::class)
            ->findAll();

        return $this->render('admin/manage_contact_douane.html.twig', [
            'contacts' =>$contacts
        ]);
    }

    /**
     * @Route("/admin/view_contact_douane/{id}", name="view_contact_douane")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function viewContactDouane($id, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(ContactDouane::class);
        $contact = $repository->find($id);

        $contact->setIsRead('true');

        $em = $this->getDoctrine()->getManager();
        $em->persist($contact);
        $em->flush();

        return $this->render('admin/view_contact.html.twig', [
            'contact' =>$contact
        ]);
    }

    /**
     * @Route("/admin/delete_contact_douane/{id}", name="delete_contact_douane")
     * @param $id
     * @return RedirectResponse
     */
    public function deleteContactDouane($id): RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(ContactDouane::class);
        $contact = $repository->find($id);

        $entityManager->remove($contact);
        $entityManager->flush();

        return $this->redirectToRoute('manage_contact');
    }

}
