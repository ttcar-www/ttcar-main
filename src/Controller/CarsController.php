<?php

namespace App\Controller;

use App\Entity\Accessory;
use App\Entity\Cars;
use App\Entity\Mark;
use App\Entity\Place;
use App\Entity\Price;
use App\Entity\Range;
use App\Entity\Slice;
use App\Entity\TypePromo;
use App\Form\AccessoryFormType;
use App\Form\CarsFormType;
use App\Form\EditCarFormType;
use App\Form\EditMarkFormType;
use App\Form\EditRangeFormType;
use App\Form\MarkFormType;
use App\Form\PlaceFormType;
use App\Form\PriceFormType;
use App\Form\PromoTypeFormType;
use App\Form\RangeFormType;
use App\Form\SlicesFormType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


class CarsController extends AbstractController
{
    /**
     * @Route("/manage_cars", name="manage_cars")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Cars::class);

        $cars = $repository->findAll();

        return $this->render('admin/manage_cars.html.twig', [
            'cars' =>$cars
        ]);
    }

    /**
     * @Route("/create_car/{id}", name="create_car")
     * @param Request $request
     * @param $id
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function createCar(Request $request, $id, FileUploader $fileUploader): Response
    {
        $repository = $this->getDoctrine()->getRepository(Range::class);

        $range = $repository->findOneBy(
            ['id' => $id]
        );

        $car = new Cars();

        $form = $this->createForm(
            CarsFormType::class,
            $car);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $car_img_name */
            $car_img_name = $form->get('carImg')->getData();

            if ($car_img_name) {
                $car_img_name = $fileUploader->upload($car_img_name);
                $car->setCarImg($car_img_name);
            }

            $car->setRanges($range);
            $car->setIsOnline(true);
            $car->setMark($range->getMark());

            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush();

            return $this->redirectToRoute('create_price', ['id' => $car->getId()]);
        }

        return $this->render('form/create_car.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/edit_car/{id}", name="edit_car")
     * @param Request $request
     * @param $id
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function editCar(Request $request, $id, FileUploader $fileUploader): Response
    {
        $car = $this->getDoctrine()
            ->getRepository(Cars::class)
            ->find($id);

        $form = $this->createForm(
            EditCarFormType::class,
            $car);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $car_img_name */
            $car_img_name = $form->get('carImg')->getData();

            if ($car_img_name) {
                $car_img_name = $fileUploader->upload($car_img_name);
                $car->setCarImg($car_img_name);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush();

            return $this->redirectToRoute('manage_cars');
        }
        return $this->render('form/editCar.html.twig', [
            'car' =>$car,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/delete_car/{id}", name="delete_car")
     * @param $id
     * @return RedirectResponse
     */
    public function deleteCar($id): RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Cars::class);
        $car = $repository->find($id);

        $entityManager->remove($car);
        $entityManager->flush();

        return $this->redirectToRoute('manage_cars');
    }


    /**
     * @Route("/detail_car/{id}", name="detail_car")
     * @param $id
     * @return Response
     */
    public function detailCar($id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Cars::class);
        $repository_mark = $this->getDoctrine()->getRepository(Mark::class);

        $car = $repository->find($id);

        $mark_id = $car->getMark();
        $marks = $repository_mark->findBy(['id' => $mark_id]);
        $mark_name = null;

        foreach($marks as $mark)
        {
            $mark_name = $mark->getLibelle();
        }

        return $this->render('main/cars_detail.html.twig', [
            'car' =>$car,
            'mark_name' => $mark_name
        ]);
    }

    /**
     * @Route("/create_type", name="create_type")
     * @param Request $request
     * @return Response
     */
    public function createType(Request $request): Response
    {
        $type = new TypePromo();

        $form = $this->createForm(
            PromoTypeFormType::class,
            $type);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('form/create_type_promo.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/create_mark", name="create_mark")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function createMark(Request $request, FileUploader $fileUploader): Response
    {
        $mark = new Mark();

        $form = $this->createForm(
            MarkFormType::class,
            $mark);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $mark_img_name */
            $mark_img_name = $form->get('markImg')->getData();

            if ($mark_img_name) {
                $mark_file_name = $fileUploader->upload($mark_img_name);
                $mark->setMarkImg($mark_file_name);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($mark);
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('form/create_mark.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit_mark/{id}", name="edit_mark")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param $id
     * @return Response
     */
    public function editMark(Request $request, FileUploader $fileUploader, $id): Response
    {
        $mark = $this->getDoctrine()
            ->getRepository(Mark::class)
            ->find($id);

        $form = $this->createForm(
            EditMarkFormType::class,
            $mark);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $mark_img_name */
            $mark_img_name = $form->get('markImg')->getData();

            if ($mark_img_name) {
                $mark_file_name = $fileUploader->upload($mark_img_name);
                $mark->setMarkImg($mark_file_name);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($mark);
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('form/edit_mark.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/create_range}", name="create_range")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function createRange(Request $request, FileUploader $fileUploader): Response
    {
        $range = new Range();

        $form = $this->createForm(
            RangeFormType::class,
            $range);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $range_img_name */
            $range_img_name = $form->get('rangeImg')->getData();

            if ($range_img_name) {
                $range_img_name = $fileUploader->upload($range_img_name);
                $range->setRangeImg($range_img_name);
            }


            $em = $this->getDoctrine()->getManager();
            $em->persist($range);
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('form/create_range.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit_range/{id}", name="edit_range")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param $id
     * @return Response
     */
    public function editRange(Request $request, FileUploader $fileUploader, $id): Response
    {
        $range = $this->getDoctrine()
            ->getRepository(Range::class)
            ->find($id);

        $form = $this->createForm(
            EditRangeFormType::class,
            $range);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $range_img_name */
            $range_img_name = $form->get('rangeImg')->getData();

            if ($range_img_name) {
                $range_img_name = $fileUploader->upload($range_img_name);
                $range->setRangeImg($range_img_name);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($range);
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('form/edit_range.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/create_price/{id}", name="create_price")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function createPrice(Request $request, $id): Response
    {
        $car = $this->getDoctrine()
            ->getRepository(Cars::class)
            ->find($id);

        $price = new Price();

        $form = $this->createForm(
            PriceFormType::class,
            $price);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $price->addCar($car);
            $car->setPrice($price);

            $em = $this->getDoctrine()->getManager();
            $em->persist($price);
            $em->persist($car);
            $em->flush();

            return $this->redirectToRoute('manage_cars');
        }

        return $this->render('form/create_price.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/create_accessory}", name="create_accessory")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function createAccessory(Request $request, FileUploader $fileUploader): Response
    {
        $accessory = new Accessory();

        $form = $this->createForm(
            AccessoryFormType::class,
            $accessory);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $car_img_name */
            $item_img_name = $form->get('itemImg')->getData();

            if ($item_img_name) {
                $item_img_name = $fileUploader->upload($item_img_name);
                $accessory->setItemImg($item_img_name);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($accessory);
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('form/create_accessory.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/create_slice/{id}", name="create_slice")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function createSlice(Request $request, $id): Response
    {
        $cars = $this->getDoctrine()
            ->getRepository(Cars::class)
            ->findBy(
                ['price' => $id]
            );

        $mark = null;
        foreach ($cars as $car){
            $mark = $car->getMark();
        }

        $price = $this->getDoctrine()
            ->getRepository(Price::class)
            ->find($id);

        $slice = new Slice();

        $form = $this->createForm(
            SlicesFormType::class,
            $slice);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $slice->setTarif($price);
            $slice->setMark($mark);

            $em = $this->getDoctrine()->getManager();
            $em->persist($slice);
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('form/create_slice.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
