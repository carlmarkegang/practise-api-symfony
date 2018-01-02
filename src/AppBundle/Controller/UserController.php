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
        #$userRepo = new UserRepository();
        $form = $this->createForm(UserType::class, $user);
        #$userRepo->loadUserByUsername($form["username"]->getData());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $getData = $form["username"]->getData();
            if($passwordEncoder->isPasswordValid($user, $user->getPlainPassword())){
                var_dump('yay');
                exit;
            }

            return $this->render('reg.html.twig', array(
                'form' => $form->createView(),
                'input' => (array)$getData,
            ));
        }

        return $this->render('reg.html.twig',
            array(
                'form' => $form->createView(),
                'input' => array('currently not working, Click <a href="/reg">here</a> to create a user'),
            )
        );
    }

}