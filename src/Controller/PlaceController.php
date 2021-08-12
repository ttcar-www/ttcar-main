<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\Nationality;
use App\Entity\Place;
use App\Entity\PlaceExtra;
use App\Entity\Reason;
use App\Form\CategoryPostFormType;
use App\Form\CountryFormType;
use App\Form\EditCountryFormType;
use App\Form\EditExtraPlaceFormType;
use App\Form\EditNationalityFormType;
use App\Form\EditPlaceFormType;
use App\Form\EditPostFormType;
use App\Form\EditReasonFormType;
use App\Form\ExtraPlaceFormType;
use App\Form\NationalityFormType;
use App\Form\NewPostFormType;
use App\Form\PlaceFormType;
use App\Form\ReasonFormType;
use App\Service\FileUploader;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class PlaceController extends AbstractController
{
    /**
     * @Route("/create_place", name="create_place")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     * @throws Exception
     */
    public function createPlace(Request $request, FileUploader $fileUploader): Response
    {
        $today = new \DateTime('@'.strtotime('now'));
        $place = new Place();

        $form = $this->createForm(
            PlaceFormType::class,
            $place);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $place->setCreateAt($today);

            /** @var UploadedFile $place_pdf */
            $place_pdf = $form->get('placePDF')->getData();

            if ($place_pdf) {
                $place_pdf = $fileUploader->upload($place_pdf);
                $place->setPlacePDF($place_pdf);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($place);
            $em->flush();


            $this->addFlash(
                'success',
                'Lieu ajouté'
            );

            return $this->redirectToRoute('create_extra_place', ['id' => $place->getId()]);
        }

        return $this->render('form/create_place.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/create_extra_place/{id}", name="create_extra_place")
     * @param Request $request
     * @param $id
     * @return Response
     * @throws Exception
     */
    public function createExtraPlace(Request $request, $id): Response
    {
        $place = $this->getDoctrine()
            ->getRepository(Place::class)
            ->findOneBy(['id' => $id]);

        $extraPlace = new PlaceExtra();

        $form = $this->createForm(
            ExtraPlaceFormType::class,
            $extraPlace);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $extraPlace->setCreateAt(new \DateTimeImmutable($request->get('time')));
            $extraPlace->addPlace($place);

            $place->setBrandId($extraPlace->getBrandId());

            $em = $this->getDoctrine()->getManager();

            $em->persist($extraPlace);
            $em->persist($place);

            $em->flush();


            $this->addFlash(
                'success',
                'Lieu ajouté'
            );

            return $this->redirectToRoute('manage_place');
        }

        return $this->render('form/create_place_extra.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/create_nationality", name="create_nationality")
     * @param Request $request
     * @return Response
     */
    public function createNationality(Request $request): Response
    {
        $nationaity = new Nationality();

        $form = $this->createForm(
            NationalityFormType::class,
            $nationaity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($nationaity);
            $em->flush();


            $this->addFlash(
                'success',
                'Nationalité ajouté'
            );

            return $this->redirectToRoute('manage_nationality');
        }

        return $this->render('form/create_nationality.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/create_country", name="create_country")
     * @param Request $request
     * @return Response
     */
    public function createCountry(Request $request): Response
    {
        $country = new Country();

        $form = $this->createForm(
            CountryFormType::class,
            $country);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($country);
            $em->flush();

            $this->addFlash(
                'success',
                'Pays ajouté'
            );

            return $this->redirectToRoute('manage_country');
        }

        return $this->render('form/create_country.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/create_work", name="create_work")
     * @param Request $request
     * @return Response
     */
    public function createWork(Request $request): Response
    {
        $reason = new Reason();

        $form = $this->createForm(
            ReasonFormType::class,
            $reason);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($reason);
            $em->flush();

            $this->addFlash(
                'success',
                'Raison ajouté'
            );

            return $this->redirectToRoute('manage_reason');
        }

        return $this->render('form/create_reason.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/edit_extra_place/{id}", name="edit_extra_place")
     * @param Request $request
     * @param $id
     * @param FileUploader $fileUploader
     * @return Response
     * @throws Exception
     */
    public function editExtraPlace(Request $request, $id): Response
    {
        $today = new \DateTimeImmutable('@'.strtotime('now'));

        $place = $this->getDoctrine()
            ->getRepository(PlaceExtra::class)
            ->find($id);

        $form = $this->createForm(
            EditExtraPlaceFormType::class,
            $place);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $place->setUpdateAt($today);

            $em = $this->getDoctrine()->getManager();
            $em->persist($place);
            $em->flush();

            $this->addFlash(
                'success',
                'Extra modifé'
            );

            return $this->redirectToRoute('manage_place');
        }
        return $this->render('form/create_place_extra.html.twig', [
            'place' =>$place,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/delete_extra_place/{id}", name="delete_extra_place")
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function deleteExtraPlace(Request $request, $id): RedirectResponse
    {
        $today = new \DateTime('@'.strtotime('now'));

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(PlaceExtra::class);
        $place = $repository->find($id);

        $place->setDeleteAt(new \DateTimeImmutable($request->get('time')));

        $entityManager->persist($place);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Lieu supprimé'
        );

        return $this->redirectToRoute('manage_place');
    }

    /**
     * @Route("/admin/delete_place/{id}", name="delete_place")
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function deletePlace(Request $request, $id): RedirectResponse
    {
        $today = new \DateTime('@'.strtotime('now'));

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Place::class);
        $place = $repository->find($id);

        $place->setDeleteAt(new \DateTimeImmutable($request->get('time')));

        $entityManager->persist($place);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Lieu supprimé'
        );

        return $this->redirectToRoute('manage_place');
    }


    /**
     * @Route("/admin/delete_country/{id}", name="delete_country")
     * @param $id
     * @return RedirectResponse
     */
    public function deleteCountry($id): RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Place::class);
        $country = $repository->find($id);

        $entityManager->remove($country);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Pays supprimé'
        );

        return $this->redirectToRoute('manage_country');
    }

    /**
     * @Route("/admin/delete_nationality/{id}", name="delete_nationality")
     * @param $id
     * @return RedirectResponse
     */
    public function deleteNationality($id): RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Nationality::class);
        $nationality = $repository->find($id);

        $entityManager->remove($nationality);
        $entityManager->flush();


        $this->addFlash(
            'success',
            'Nationalité supprimé'
        );

        return $this->redirectToRoute('manage_nationality');
    }

    /**
     * @Route("/admin/delete_reason/{id}", name="delete_reason")
     * @param $id
     * @return RedirectResponse
     */
    public function deleteReason($id): RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Nationality::class);
        $reason = $repository->find($id);

        $entityManager->remove($reason);
        $entityManager->flush();


        $this->addFlash(
            'success',
            'Raison supprimé'
        );

        return $this->redirectToRoute('manage_reason');
    }

    /**
     * @Route("/admin/edit_place/{id}", name="edit_place")
     * @param Request $request
     * @param $id
     * @param FileUploader $fileUploader
     * @return Response
     * @throws Exception
     */
    public function editPlace(Request $request, $id, FileUploader $fileUploader): Response
    {
        $today = new \DateTime('@'.strtotime('now'));

        $place = $this->getDoctrine()
            ->getRepository(Place::class)
            ->find($id);

        $form = $this->createForm(
            EditPlaceFormType::class,
            $place);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $place->setUpdateAt($today);

            /** @var UploadedFile $place_pdf */
            $place_pdf = $form->get('placePDF')->getData();

            if ($place_pdf) {
                $place_pdf = $fileUploader->upload($place_pdf);
                $place->setPlacePDF($place_pdf);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($place);
            $em->flush();

            $this->addFlash(
                'success',
                'Lieu modifé'
            );

            return $this->redirectToRoute('manage_place');
        }
        return $this->render('form/create_place.html.twig', [
            'place' =>$place,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/edit_nationality/{id}", name="edit_nationality")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editNationality(Request $request, $id): Response
    {
        $nationality = $this->getDoctrine()
            ->getRepository(Nationality::class)
            ->find($id);

        $form = $this->createForm(
            EditNationalityFormType::class,
            $nationality);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($nationality);
            $em->flush();

            $this->addFlash(
                'success',
                'Nationalité modifé'
            );

            return $this->redirectToRoute('manage_nationality');
        }
        return $this->render('form/create_nationality.html.twig', [
            'nationality' =>$nationality,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/edit_country/{id}", name="edit_country")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editCountry(Request $request, $id): Response
    {
        $country = $this->getDoctrine()
            ->getRepository(Country::class)
            ->find($id);

        $form = $this->createForm(
            EditCountryFormType::class,
            $country);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($country);
            $em->flush();

            $this->addFlash(
                'success',
                'Pays modifé'
            );

            return $this->redirectToRoute('manage_country');
        }
        return $this->render('form/create_nationality.html.twig', [
            'country' =>$country,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/edit_reason/{id}", name="edit_reason")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editReason(Request $request, $id): Response
    {
        $reason = $this->getDoctrine()
            ->getRepository(Reason::class)
            ->find($id);

        $form = $this->createForm(
            EditReasonFormType::class,
            $reason);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($reason);
            $em->flush();


            $this->addFlash(
                'success',
                'Raison modifé'
            );

            return $this->redirectToRoute('manage_reason');
        }
        return $this->render('form/create_reason.html.twig', [
            'nationality' =>$reason,
            'form' => $form->createView()
        ]);
    }
}
