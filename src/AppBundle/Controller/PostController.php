<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class PostController extends Controller
{

    /**
     * @Route("/posts/{id}", defaults={"id": null}, requirements={"id"="\d+"})
     */
    public function showPosts($id)
    {
        $repository = $this->getDoctrine()->getRepository(Post::class);

        if (!$id){
            $post = $repository->findBy(array('type' => 'main'));
        }

        if (!$post) {
            $post = $repository->find($id);
            $post = array($post);
        }

        return $this->render('posts.html.twig', array(
            'posts' => (array)$post,
        ));

    }


}