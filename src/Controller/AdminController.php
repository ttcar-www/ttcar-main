<?php

namespace App\Controller;

use App\Entity\Accessory;
use App\Entity\Blog;
use App\Entity\Contact;
use App\Entity\Country;
use App\Entity\Customer;
use App\Entity\Mark;
use App\Entity\Nationality;
use App\Entity\Order;
use App\Entity\Place;
use App\Entity\Price;
use App\Entity\Promotions;
use App\Entity\Range;
use App\Entity\Reason;
use App\Entity\User;
use App\Form\ContactFormType;
use App\Form\EditAccessoryFormType;
use App\Form\EditPostFormType;
use App\Form\NewPostFormType;
use App\Form\PromotionFormType;
use App\Form\RegistrationFormType;
use App\Form\TtcarFormType;
use App\Form\UserEditFormType;
use App\Form\UserFormType;
use App\Service\FileUploader;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
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
     * @Route("/admin/manage_place", name="manage_place")
     * @return Response
     */
    public function managePlace(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Place::class);
        $places = $repository->findAll();

        return $this->render('admin/manage_place.html.twig', [
            'places' =>$places
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
        $repository = $this->getDoctrine()->getRepository(Price::class);

        $prices = $repository->findAll();

        return $this->render('admin/manage_prices.html.twig', [
            'prices' =>$prices
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

            return $this->redirectToRoute('manage_user');
        }
        return $this->render('form/edit_user.html.twig', [
            'user' =>$user,
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

        return $this->redirectToRoute('manage_accessory');
    }
}
