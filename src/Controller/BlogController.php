<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('/blog/home.html.twig', [
            'title' => 'Bienvenue ici les amis',
            'age' => 2,
        ]);
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repository)
    {
        $articles = $repository->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/blog/article/{id}", name="blog_show", requirements={"id"="\d+"})
     */
    public function show(Article $article, Request $request, EntityManagerInterface $entityManager)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $comment->setCreateAt(new \DateTime())
                    ->setArticle($article);

            $comment = $form->getData();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('blog_show', ['id' => $article->getId()], 301);
        }

        return $this->render('blog/show.html.twig', [
            'article' => $article,
            'commentForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id<\d+>}/edit", name="blog_edit")
     */
    public function form(Article $article = null, Request $request, EntityManagerInterface $entityManager)
    {
        if(!$article) {
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            if(!$article->getId()) {
                $article->setCreatedAt(new \DateTime());
            }

            $article = $form->getData();

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('blog_show', ['id' => $article->getId()], 301);
        }

        return $this->render('/blog/create.html.twig', [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null,
        ]);
    }
}
