<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\CategoryPost;
use App\Form\CategoryPostFormType;
use App\Form\EditPostFormType;
use App\Form\NewPostFormType;
use App\Service\FileUploader;
use DateTime;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class BlogController extends AbstractController
{

    /**
     * @Route("/blog/", name="blog")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function blog(PaginatorInterface $paginator, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Blog::class);
        $repositoryCategory = $this->getDoctrine()->getRepository(CategoryPost::class);

        $lastPosts = $repository->findThreeLast();
        $categories = $repositoryCategory->findAll();

        $pagination = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('main/blog.html.twig', [
            'pagination' => $pagination,
            'categories' => $categories,
            'lastPosts' => $lastPosts
        ]);
    }

    /**
     * @Route("/manage_blog/", name="manage_blog")
     * @return Response
     */
    public function managePost(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Blog::class);
        $posts = $repository->findAll();

        return $this->render('admin/manage_posts.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/create_post/", name="create_post")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     * @throws Exception
     */
    public function createPost(Request $request, FileUploader $fileUploader): Response
    {
        $today = new DateTime('@'.strtotime('now'));

        $post = new Blog();

        $form = $this->createForm(
            NewPostFormType::class,
            $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $post_img */
            $post_img = $form->get('postImg')->getData();

            if ($post_img) {
                $post_img = $fileUploader->upload($post_img);
                $post->setPostImg($post_img);
            }

            $post->setCreateAt($today);
            $post->setAuthor('slothie');

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash(
                'success',
                'Article créé'
            );

            return $this->redirectToRoute('manage_blog');
        }
        return $this->render('form/create_post.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/see_post/{id}", name="see_post")
     * @param $id
     * @return Response
     */
    public function seePost($id): Response
    {
        $repositoryCategory = $this->getDoctrine()->getRepository(CategoryPost::class);
        $repository = $this->getDoctrine()->getRepository(Blog::class);

        $post = $repository->find($id);
        $lastPost = $repository->findThreeLast();
        $categories = $repositoryCategory->findAll();

        return $this->render('main/post.html.twig', [
            'post' =>$post,
            'lastPost' => $lastPost,
            'categories' => $categories
        ]);
    }


    /**
     * @Route("/edit_post/{id}", name="edit_post")
     * @param Request $request
     * @param $id
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function editPost(Request $request, $id, FileUploader $fileUploader): Response
    {
        $post = $this->getDoctrine()
            ->getRepository(Blog::class)
            ->find($id);

        $form = $this->createForm(
            EditPostFormType::class,
            $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $post_img */
            $post_img = $form->get('postImg')->getData();

            if ($post_img) {
                $post_img = $fileUploader->upload($post_img);
                $post->setPostImg($post_img);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash(
                'success',
                'Article modifié'
            );

            return $this->redirectToRoute('manage_blog');
        }
        return $this->render('form/create_post.html.twig', [
            'post' =>$post,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/delete_post/{id}", name="delete_post")
     * @param $id
     * @return RedirectResponse
     */
    public function deletePost($id): RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Blog::class);
        $post = $repository->find($id);

        $entityManager->remove($post);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Article supprimé'
        );

        return $this->redirectToRoute('manage_user');
    }

    /**
     * @Route("/create_category_post/", name="create_category_post")
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function createCategoryPost(Request $request): Response
    {
        $categoryPost = new CategoryPost();

        $form = $this->createForm(
            CategoryPostFormType::class,
            $categoryPost);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($categoryPost);
            $em->flush();

            $this->addFlash(
                'success',
                'Catégorie créé'
            );

            return $this->redirectToRoute('manage_blog');
        }
        return $this->render('form/categoryPost.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/findByCategory/{id}", name="findByCategory")
     * @param $id
     * @return Response
     */
    public function findByCategory($id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Blog::class);
        $repositoryCategory = $this->getDoctrine()->getRepository(CategoryPost::class);

        $category = $repositoryCategory->findOneBy(['id' => $id]);
        $posts = $repository->findBy(['categoryPost' => $category]);


        return $this->render('main/blog_category.html.twig', [
            'posts' => $posts,
            'category' => $category
        ]);
    }
}
