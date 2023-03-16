<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\UpdatePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PasswordUpdateController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;
    public function __construct(EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher){
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }
    #[Route('/app_compte/modifiermotdepasse', name: 'app_password_update')]
    public function index(Request $request, EntityManagerInterface $entityManager,UserPasswordHasherInterface $encoder): Response
    {
        $notification = null;
        $user = $this->getUser();
        $form = $this->createForm(UpdatePasswordType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $old_pwd = $form->get('old_password')->getData();
            if($encoder->isPasswordValid($user,$old_pwd)){
                $new_pwd = $form->get('new_password')->getData();
                $encodedPassword = $this->passwordHasher->hashPassword($user, $new_pwd);
                $user->setPassword($encodedPassword);
                $this->entityManager->flush();
                $notification = "Votre nouveau mot de passe à bien été mis à jour";
            }else{
                $notification = "La modification de votre nouveau mot de passe n'est pas correct";
            }
        }
        return $this->render('/compte/password.html.twig',[
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
