<?php

namespace App\Controller;
use App\Form\InscriptionType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class FormController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;
    public function __construct(EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher){
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }
    #[Route('/inscription', name: 'app_form')]
public function index(Request $request, EntityManagerInterface $entityManager,UserPasswordHasherInterface $encoder)
{
    
    $user = new User();
    $form = $this->createForm(InscriptionType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Retrieve plain text password from the form data
        $plainPassword = $form->get('password')->getData();

        // Encode the password
        $encodedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);

        // Set the encoded password on the user object
        $user->setPassword($encodedPassword);
        $entityManager->flush();

        // Redirect the user to a success page
        //return $this->redirectToRoute('app_success');
    }

    return $this->render('form/index.html.twig',[
        'form' => $form->createView()
    ]);
}
}
