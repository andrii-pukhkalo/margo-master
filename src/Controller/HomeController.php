<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, array('label' => 'Имя'))
            ->add('email',EmailType::class, array('label' => 'Эл. почта'))
            ->add('message',TextAreaType::class, array('label' => 'Сообщение'))
            ->add('save', SubmitType::class, array('label' => 'Отравить'))
            ->getForm();

        $form->handleRequest($request);

        if  ($form->isSubmitted() && $form->isValid())
        {
            $formData = $form->getData();

            $body = $formData['name'] . ' ' . $formData['email'] . ' ' . $formData['message'];

            $message = (new \Swift_Message($formData['name']))
                ->setFrom('send@example.com')
                ->setTo('puhkaloandrew@gmail.com')
                ->setBody((string)$body);

            $mailer->send($message);

        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/email")
     */
//    public function email(\Swift_Mailer $mailer)
//    {
//
//
//        $message = (new \Swift_Message('Hello Email'))
//            ->setFrom('send@example.com')
//            ->setTo('puhkaloandrew@gmail.com')
//            ->setBody('hello');
//
//        $mailer->send($message);
//
//        return new Response('done');
//    }
}
