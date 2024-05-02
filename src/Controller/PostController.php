<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostController extends AbstractController
{
    public function __construct(
        private PostRepository $postRepository,
        private EntityManagerInterface $entityManager
        )
        {}

    #[Route('/post', name: 'posts')]
    public function index(): Response
    {
        $posts = $this->postRepository->findBy([], ['id' => 'DESC']);
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/create-post', name: 'create_post')]
    public function create(Request $request): Response
    {
       $post= new Post();
       $form=$this->createForm(PostType::class, $post);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
           $this->entityManager->persist($post);
           $this->entityManager->flush();
           $this->addFlash('message', 'Post created successfully');
           return $this->redirectToRoute('posts');
       }
        return $this->render('post/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit-post/{id}', name: 'edit_post')]
    public function edit(Request $request, string $id): Response
    {
       $post= $this->postRepository->find($id);
       $form=$this->createForm(PostType::class, $post);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
           $this->entityManager->persist($post);
           $this->entityManager->flush();
           $this->addFlash('message', 'Post update successfully');
           return $this->redirectToRoute('posts');
       }
        return $this->render('post/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/delete-post/{id}', name: 'delete_post')]
    public function delete(string $id)
    {
        $post = $this->postRepository->find($id);
        $this->entityManager->remove($post);
        $this->entityManager->flush();
        $this->addFlash('message', 'Post deleted successfully');
        return $this->redirectToRoute('posts');
    }
}
