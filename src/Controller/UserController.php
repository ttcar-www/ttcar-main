<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\User;
use App\Form\CustomerFormType;
use App\Form\EditCustomerFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class UserController extends AbstractController
{
    /**
     * @Route("/account/", name="account")
     * @return Response
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $nationality = null;
        $country_ue = null;
        $country_hue = null;
        $reason = null;

        if ($user){
            if ($user->getCustomer() === null){

             return $this->redirectToRoute('create_customer');
            }else{
                $user = $this->getDoctrine()
                    ->getRepository(Customer::class)
                    ->findOneBy(['user' => $user->getId()]);

                $nationality = $user->getNationality()->getNameFr();
                $country_ue = $user->getAdressCountry()->getNameFr();
                $country_hue = $user->getAdressCountryHue()->getNameFr();
            }
        }

        return $this->render('main/account.html.twig', [
            'user' =>$user,
            'nationality' => $nationality,
            'countryUe' => $country_ue,
            'countryHue' => $country_hue
        ]);
    }

    /**
     * @Route("/my_order/", name="my_order")
     * @return Response
     */
    public function profilOrder(): Response
    {
        $user = $this->getUser();
        $orders = null;
        if ($user->getCustomer() == true) {
            $customer = $this->getDoctrine()
                ->getRepository(Customer::class)
                ->findOneBy(['email' => $user->getEmail()]);

            $orders = $this->getDoctrine()
                ->getRepository(Order::class)
                ->findBy(['email' => $customer->getEmail()]);

        }

        return $this->render('main/my_order.html.twig',
            [
               'orders'=>$orders
            ]);
    }


    /**
     * @Route("/view_order/{id}", name="view_order")
     * @param $id
     * @return Response
     */
    public function viewOrder($id): Response
    {
        $order = $this->getDoctrine()
            ->getRepository(Order::class)
            ->findOneBy(['id' => $id]);

        return $this->render('main/view_order.html.twig',
            [
                'order'=>$order
            ]);
    }


    /**
     * @Route("/create_customer/", name="create_customer")
     * @param Request $request
     * @return Response
     */
    public function createCustomer(Request $request): Response
    {
        $customer = new Customer();

        $form = $this->createForm(
            CustomerFormType::class,
            $customer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(['id' => $this->getUser()]);

            $user->setIsCustomer(true);

            $customer->setUser($user);
            $customer->setEmail($user->getEmail());

            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Profil créé'
            );

            return $this->redirectToRoute('account');
        }
        return $this->render('form/create_customer.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit_customer/", name="edit_customer")
     * @param Request $request
     * @return Response
     */
    public function editCustomer(Request $request): Response
    {
        $user = $this->getUser();

        $customer = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->findOneBy(['user' => $user->getId()]);

        $form = $this->createForm(
            EditCustomerFormType::class,
            $customer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            $this->addFlash(
                'success',
                'Profil modifié'
            );


            return $this->redirectToRoute('account');
        }
        return $this->render('form/create_customer.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit_customer_bo/{id}", name="edit_customer_bo")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editCustomerBo(Request $request, $id): Response
    {
        $customer = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->findOneBy(['user' => $id]);

        $form = $this->createForm(
            EditCustomerFormType::class,
            $customer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            $this->addFlash(
                'success',
                'Client modifé'
            );


            return $this->redirectToRoute('manage_customer');
        }
        return $this->render('form/create_customer.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
