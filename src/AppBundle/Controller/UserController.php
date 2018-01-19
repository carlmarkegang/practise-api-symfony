<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Users;
use AppBundle\Repository\UserRepository;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class UserController extends Controller
{
    /**
     * @Route("/user/{id}", defaults={"id": null}, requirements={"id"="\d+"})
     */
    public function showAction($id)
    {
        if (!$id)
            $username = 'not found';

        if (!$username) {
            $user = $this->getDoctrine()
                ->getRepository(Users::class)
                ->find($id);

            $username = $user->getUsername();
        }

        return $this->render('user.html.twig', array(
            'username' => $username,
        ));

    }

    /**
     * @Route("/reg", name="registration")
     */
    public function showReg(Request $request, UserPasswordEncoderInterface $passwordEncoder = null)
    {
        $user = new Users();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $getData = $form["username"]->getData();
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $user->setToken('token');

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->render('reg.html.twig', array(
                'form' => $form->createView(),
                'input' => (array)$getData,
            ));
        }

        return $this->render('reg.html.twig',
            array(
                'form' => $form->createView(),
                'input' => array(''),
            )
        );
    }

    /**
     * @Route("/login", name="login")
     */
    public function showLogin(Request $request, UserPasswordEncoderInterface $passwordEncoder = null)
    {
        $user = new Users();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);;
        if ($form->isSubmitted()) {

            $getUser = $this->getDoctrine()->getRepository(Users::class)->findOneBy(array("username"=>$form["username"]->getData()));

            if($passwordEncoder->isPasswordValid($getUser, $user->getPlainPassword())){

                $session = new Session();
                session_destroy();
                $session->start();
                $session->set('username', $getUser->getUsername());
            }

            return $this->render('reg.html.twig', array(
                'form' => $form->createView(),
                'input' => array('logged in as ' . $session->get('username')),
            ));
        }

        return $this->render('reg.html.twig',
            array(
                'form' => $form->createView(),
                'input' => array('Click <a href="/reg">here</a> to create a user'),
            )
        );
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function showLogout()
    {
                session_destroy();
                return $this->redirectToRoute('homepage');
    }

}