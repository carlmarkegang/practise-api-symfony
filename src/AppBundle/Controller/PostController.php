<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class PostController extends Controller
{

    /**
     * @Route("/posts/{id}", defaults={"id": null}, requirements={"id"="\d+"})
     */
    public function showPosts($id)
    {
        $session = new Session();
        if($session->get('username')){
            dump($session->get('username'));
        }
        $repository = $this->getDoctrine()->getRepository(Post::class);

        if (!$id){
            $post = $repository->findBy(array('type' => 'main'));
        }

        if (!$post) {
            $post = $repository->find($id);
            $subpost = $repository->findBy(array('type' => 'sub', 'parent' => $id));
            $post = array($post);
            return $this->render('post.html.twig', array(
                'posts' => (array)$post,
                'subposts' => (array)$subpost,
            ));
        }

        return $this->render('posts.html.twig', array(
            'posts' => (array)$post,
            'subposts' => array(''),
        ));
    }


    function time_elapsed_string($datetime, $full = false)
    {
        $now = new \DateTime;
        $ago = new \DateTime();
        $ago->setTimestamp($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

}