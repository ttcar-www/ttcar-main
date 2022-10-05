<?php

namespace App\Controller;

use App\Entity\Accessory;
use App\Entity\Cars;
use App\Entity\CategoryResacar;
use App\Entity\Contact;
use App\Entity\Country;
use App\Entity\Customer;
use App\Entity\Doc;
use App\Entity\Mark;
use App\Entity\Nationality;
use App\Entity\Order;
use App\Entity\Place;
use App\Entity\PlaceExtra;
use App\Entity\Price;
use App\Entity\PriceSupplier;
use App\Entity\Range;
use App\Entity\Reason;
use App\Entity\Slice;
use App\Entity\SliceSupplier;
use App\Entity\User;
use App\Form\CategoryResacarFormType;
use App\Form\EditAccessoryFormType;
use App\Form\UserEditFormType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin/dashboard/", name="dashboard")
     * @return Response
     */
    public function index(): Response
    {
        if ($this->getUser()){
            $user = $this->getUser();
        }else{
            $user = "slothDev";
        }
        $repository = $this->getDoctrine()->getRepository(Order::class);
        $repositoryUser = $this->getDoctrine()->getRepository(Customer::class);
        $repositoryContact = $this->getDoctrine()->getRepository(Contact::class);

        $contacts = $repositoryContact->findBy(['isRead' => false]);

        $users = $repositoryUser->findTenLastUser();
        $orders = $repository->findTenLast();

        $arrayPrice = [];
        foreach ($orders as $order) {
           array_push($arrayPrice, $order->getPrice());
        }

        $sommePrice = array_sum($arrayPrice);

        return $this->render('admin/dashboard.html.twig', [
            'user' =>$user,
            'users' => $users,
            'orders' => $orders,
            'contacts' => $contacts,
            'sommePrice' => $sommePrice,
            'arrayPrice' => $arrayPrice
        ]);
    }

    /**
     * @Route("/admin/manage_customer", name="manage_customer")
     * @return Response
     */
    public function manageCustomer(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Customer::class);
        $customers = $repository->findAllByDate();

        return $this->render('admin/manage_customer.html.twig', [
            'customers' =>$customers
        ]);
    }

    /**
     * @Route("/admin/manage_user", name="manage_user")
     * @return Response
     */
    public function manageUser(): Response
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();

        return $this->render('admin/manage_users.html.twig', [
            'users' =>$users
        ]);
    }

    /**
     * @Route("/admin/manage_order", name="manage_order")
     * @return Response
     */
    public function manageOrder(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Order::class);
        $orders = $repository->findAllByDate();

        return $this->render('admin/manage_order.html.twig', [
            'orders' =>$orders
        ]);
    }

    /**
     * @Route("/admin/manage_place", name="manage_place")
     * @return Response
     */
    public function managePlace(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Place::class);
        $places = $repository->findBy(['delete_at' => NULL]);
        $arrayRenaut = [];
        $arrayPSA = [];

        foreach ($places as $place) {
            $extras = $place->getPlace();
            foreach ($extras as $extra) {
                if ($extra->getBrand() == 1) {
                    array_push($arrayRenaut, $place);
                }else {
                    array_push($arrayPSA, $place);
                }
            }
        }

        return $this->render('admin/manage_place.html.twig', [
            'arrayRenaut' =>$arrayRenaut,
            'arrayPSA' => $arrayPSA
        ]);
    }

    /**
     * @Route("/admin/manage_extra_place/{id}", name="manage_extra_place")
     * @param $id
     * @return Response
     */
    public function manageExtraPlace($id): Response
    {
        $extraPlaces = $this->getDoctrine()->getRepository(PlaceExtra::class)->findBy(['deleted_at' => null]);
        $placeName = $this->getDoctrine()->getRepository(Place::class)->findOneBy(['id'=> $id]);

        foreach ($extraPlaces as $place) {
            $placeMany = $place->getPlace();
            foreach ($placeMany as $onePlace) {
                if ($onePlace->getLibelle() == $placeName->getLibelle()) {
                    $extraPlacesArray[] = array(
                        'id' => $place->getId(),
                        'extra1' => $place->getExtra1(),
                        'extra2' => $place->getExtra2(),
                        'daysLimit' => $place->getDaysLimit(),
                        'free' => $place->getFree()
                    );
                }
            }
        }

        return $this->render('admin/manage_extra_place.html.twig', [
            'extraPlacesArray' =>$extraPlacesArray
        ]);
    }

    /**
     * @Route("/admin/manage_country", name="manage_country")
     * @return Response
     */
    public function manageCountry(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Country::class);
        $countrie = $repository->findAll();

        return $this->render('admin/manage_country.html.twig', [
            'countrie' =>$countrie
        ]);
    }

    /**
     * @Route("/admin/manage_nationality", name="manage_nationality")
     * @return Response
     */
    public function manageNationality(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Nationality::class);
        $nationalities = $repository->findAll();

        return $this->render('admin/manage_nationality.html.twig', [
            'nationalities' =>$nationalities
        ]);
    }


    /**
     * @Route("/admin/manage_reason", name="manage_reason")
     * @return Response
     */
    public function manageReason(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Reason::class);
        $reasons = $repository->findAll();

        return $this->render('admin/manage_reason.html.twig', [
            'reasons' =>$reasons
        ]);
    }

    /**
     * @Route("/manage_range", name="manage_range")
     */
    public function manageRange(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Mark::class);

        $marks = $repository->findAll();

        return $this->render('admin/all_range.html.twig', [
            'marks' =>$marks
        ]);
    }

    /**
     * @Route("/manage_accessory", name="manage_accessory")
     */
    public function manageAccessory(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Accessory::class);

        $accessories = $repository->findAll();

        return $this->render('admin/manage_accessory.html.twig', [
            'accessories' =>$accessories
        ]);
    }

    /**
     * @Route("/manage_price", name="manage_price")
     */
    public function managePrice(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Cars::class);

        $prices = $repository->findAll();

        return $this->render('admin/manage_prices.html.twig', [
            'cars' =>$prices
        ]);
    }

    /**
     * @Route("/manage_slice/{id}", name="manage_slice")
     * @param $id
     * @return Response
     */
    public function manageSlice($id): Response
    {
        $price = $this->getDoctrine()
            ->getRepository(Price::class)
            ->findOneBy(['id' => $id]);

        $priceSupplier = $this->getDoctrine()
            ->getRepository(PriceSupplier::class)
            ->findOneBy(['price_customer' => $price->getId()]);


        $slicesSupplier = $this->getDoctrine()
            ->getRepository(SliceSupplier::class)
            ->findBy(
                ['price' => $priceSupplier->getId()], ['days' => 'ASC']
            );

        $originalPrice = $price->getPrice();
        $originalPriceSupplier = $priceSupplier->getPrice();

        $slices = $this->getDoctrine()
            ->getRepository(Slice::class)
            ->findBy(
                ['tarif' => $price->getId()], ['days' => 'ASC']
            );


        $slicesArray = [];
        $countSlice = count($slices);
        $minDay = null;
        $i = 0;
        foreach ( $slices as $slice ) {
            if ($slice->getTarif()->getId() == $price->getId()) {
                array_push($slicesArray, $slice);
            }
            if(++$i === $countSlice) {
                $minDay = $slice->getDays();
            }
        }

        return $this->render('admin/manage_slice.html.twig', [
            'slices' => $slicesArray,
            'slicesSupplier' => $slicesSupplier,
            'originalPrice' => $originalPrice,
            'minDay' => $minDay,
            'originalPriceSupplier' => $originalPriceSupplier,
            'priceId' => $price->getId()
        ]);
    }

    /**
     * @Route("/manage_slice_by_price", name="manage_slice_by_price")
     */
    public function manageSliceByPrice(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Cars::class);

        $cars = $repository->findAll();

        return $this->render('admin/manage_slice_by_price.html.twig', [
            'cars' =>$cars
        ]);
    }

    /**
     * @Route("/manage_mark", name="manage_mark")
     */
    public function manageMark(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Mark::class);

        $marks = $repository->findAll();

        return $this->render('admin/manage_mark.html.twig', [
            'marks' =>$marks
        ]);
    }

    /**
     * @Route("/manage_doc", name="manage_doc")
     */
    public function manageDoc(EntityManagerInterface $entityManager): Response
    {
        $docs = $entityManager->getRepository(Doc::class)->findAll();

        return $this->render('admin/manage_doc.html.twig', [
            'docs' =>$docs
        ]);
    }

    /**
     * @Route("/manage_resacar", name="manage_resacar")
     */
    public function manageResacar(): Response
    {

        $categories = $this->getDoctrine()->getRepository(CategoryResacar::class)->findAll();


        return $this->render('admin/manage_resacar.html.twig', [
            'categories' =>$categories
        ]);
    }


    /**
     * Manage range with back office
     * @Route("/path_to_range/{path}", name="path_to_range")
     * @param $path
     * @return Response
     */
    public function pathToRange($path): Response
    {
        $repository = $this->getDoctrine()->getRepository(Range::class);

        $ranges = $repository->findBy(
            ['mark' => $path]
        );
        return $this->render('admin/manage_ranges.html.twig', [
            'ranges' =>$ranges
        ]);
    }

    /**
     * @Route("/admin/edit_user/{id}", name="edit_user")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editUser(Request $request, $id): Response
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $form = $this->createForm(
            UserEditFormType::class,
            $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Utilisateur modifié'
            );

            return $this->redirectToRoute('manage_user');
        }
        return $this->render('form/edit_user.html.twig', [
            'user' =>$user,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/create_cat_resa/", name="create_cat_resa")
     * @param Request $request
     * @return Response
     */
    public function createCatResacar(Request $request): Response
    {
        $category = New CategoryResacar();

        $form = $this->createForm(
            CategoryResacarFormType::class,
            $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash(
                'success',
                'Catégorie créé'
            );

            return $this->redirectToRoute('manage_resacar');
        }
        return $this->render('form/create_category_resacar.html.twig', [
            'category' =>$category,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/delete_cat_resacar/{id}", name="delete_cat_resacar")
     * @param $id
     * @return RedirectResponse
     */
    public function deleteCatResa($id): RedirectResponse
    {
        $category = $this->getDoctrine()
            ->getRepository(CategoryResacar::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

        $this->addFlash(
            'success',
            'Catégorie supprimé'
        );

        return $this->redirectToRoute('manage_user');
    }

    /**
     * @Route("/admin/edit_cat_resa/{id}", name="edit_cat_resa")
     * @param Request $request
     * @return Response
     */
    public function editCatResacar(Request $request, $id): Response
    {
        $category = $this->getDoctrine()
            ->getRepository(CategoryResacar::class)
            ->find($id);

        $form = $this->createForm(
            CategoryResacarFormType::class,
            $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash(
                'success',
                'Catégorie modifié'
            );

            return $this->redirectToRoute('manage_resacar');
        }
        return $this->render('form/create_category_resacar.html.twig', [
            'category' =>$category,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/delete_user/{id}", name="delete_user")
     * @param $id
     * @return RedirectResponse
     */
    public function deleteUser($id): RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->find($id);

        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Utilisateur supprimé'
        );

        return $this->redirectToRoute('manage_user');
    }

    /**
     * @Route("/admin/edit_accessory/{id}", name="edit_accessory")
     * @param Request $request
     * @param $id
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function editAccessory(Request $request, $id, FileUploader $fileUploader): Response
    {
        $accessory = $this->getDoctrine()
            ->getRepository(Accessory::class)
            ->find($id);

        $form = $this->createForm(
            EditAccessoryFormType::class,
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

            $this->addFlash(
                'success',
                'Accessoire modifié'
            );

            return $this->redirectToRoute('manage_accessory');
        }
        return $this->render('form/edit_accessory.html.twig', [
            'accessory' =>$accessory,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/delete_accessory/{id}", name="delete_accessory")
     * @param $id
     * @return RedirectResponse
     */
    public function deleteAccessory($id): RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Accessory::class);
        $accessory = $repository->find($id);

        $entityManager->remove($accessory);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Accessoire supprimé'
        );

        return $this->redirectToRoute('manage_accessory');
    }

    /**
     * @Route("/admin/view_order_admin/{id}", name="view_order_admin")
     * @param $id
     * @return Response
     */
    public function viewOrder($id): Response
    {
        $order = $this->getDoctrine()
            ->getRepository(Order::class)
            ->findOneBy(['id' => $id]);

        return $this->render('admin/view_order.html.twig',
            [
                'order'=>$order
            ]);
    }
}
