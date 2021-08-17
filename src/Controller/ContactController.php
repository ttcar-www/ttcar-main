<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Entity\Contact;
use App\Entity\ContactCars;
use App\Form\ContactByCarFormType;
use App\Form\ContactFormType;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function contact(Request $request): Response
    {
        $contact = new Contact();
        $date = new DateTime('@'.strtotime('now'));

        $form = $this->createForm(
            ContactFormType::class,
            $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $contact->setCreateAt($date);
            $contact->setIsRead(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->addFlash(
                'success',
                'Message envoyé'
            );

            return $this->redirectToRoute('main');
        }

        return $this->render('form/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/contactByCar/{id}", name="contactByCar")
     * @param Request $request
     * @param $id
     * @return Response
     * @throws Exception
     */
    public function contactByCar(Request $request, $id): Response
    {
        $contact = new ContactCars();
        $date = new DateTime('@'.strtotime('now'));
        $car = $this->getDoctrine()
            ->getRepository(Cars::class)
            ->findOneBy(['id' => $id]);

        $form = $this->createForm(
            ContactByCarFormType::class,
            $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $contact->setCreateAt($date);
            $contact->setIsRead(false);
            $contact->setCarId($id);

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->addFlash(
                'success',
                'Message envoyé'
            );

            return $this->redirectToRoute('main');
        }

        return $this->render('form/contacByCar.html.twig', [
            'form' => $form->createView(),
            'car' =>$car
        ]);
    }

    /**
     * @Route("/admin/manage_contact", name="manage_contact")
     * @return Response
     */
    public function manageContact(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Contact::class);
        $contacts = $repository->findAll();

        return $this->render('admin/manage_contact.html.twig', [
            'contacts' =>$contacts
        ]);
    }

    /**
     * @Route("/admin/manage_contact_car", name="manage_contact_car")
     * @return Response
     */
    public function manageContactCar(): Response
    {
        $contacts = $this->getDoctrine()
            ->getRepository(ContactCars::class)
            ->findAll();

        return $this->render('admin/manage_contact_car.html.twig', [
            'contacts' =>$contacts
        ]);
    }

    /**
     * @Route("/admin/view_contact{id}", name="view_contact")
     * @param $id
     * @return Response
     */
    public function viewContact($id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Contact::class);
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
     * @Route("/admin/delete_contact/{id}", name="delete_contact")
     * @param $id
     * @return RedirectResponse
     */
    public function deleteContact($id): RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Contact::class);
        $contact = $repository->find($id);

        $entityManager->remove($contact);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Message supprimé'
        );

        return $this->redirectToRoute('manage_contact');
    }


    /**
     * @Route("/admin/view_contact_car/{id}", name="view_contact_car")
     * @param $id
     * @return Response
     */
    public function viewContactCar($id): Response
    {
        $repository = $this->getDoctrine()->getRepository(ContactCars::class);
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
     * @Route("/admin/delete_contact_car/{id}", name="delete_contact_car")
     * @param $id
     * @return RedirectResponse
     */
    public function deleteContactCar($id): RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(ContactCars::class);
        $contact = $repository->find($id);

        $entityManager->remove($contact);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Message supprimé'
        );

        return $this->redirectToRoute('manage_contact_car');
    }

}
