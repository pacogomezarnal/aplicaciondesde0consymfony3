<?php

namespace TapasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TapasBundle\Entity\Usuario;
use TapasBundle\Entity\Tapa;
use TapasBundle\Entity\Reserva;
use TapasBundle\Form\TapaType;
use TapasBundle\Form\UsuarioType;
use TapasBundle\Form\ReservaType;

/**
 * @Route("/gestion")
 */
class GestionController extends Controller
{
    /**
     * @Route("/",name="gestion_home")
     */
    public function indexAction()
    {
      return $this->render('gestion/index.html.twig');
    }
    /**
     * @Route("/login",name="gestion_login")
     */
    public function loginAction(Request $request)
    {
      $authenticationUtils = $this->get('security.authentication_utils');

      // get the login error if there is one
      $error = $authenticationUtils->getLastAuthenticationError();

      // last username entered by the user
      $lastUsername = $authenticationUtils->getLastUsername();

      return $this->render('gestion/login.html.twig', array(
          'last_username' => $lastUsername,
          'error'         => $error,
      ));
    }
    /**
     * @Route("/nuevaTapa/{id}",name="gestion_nueva_tapa")
     */
    public function nuevaTapaAdminAction(Request $request,$id=null)
    {
      $urlFoto="";
      if($id==null){
        $tapa = new Tapa();
      }else{
        $em = $this->getDoctrine()->getManager();
        $tapa = $em->getRepository(Tapa::class)->find($id);
        $urlFoto=$tapa->getFoto();
        $tapa->setFoto(null);
      }
      $form = $this->createForm(TapaType::class, $tapa);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $tapa = $form->getData();
        // $file stores the uploaded PDF file
        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $fotoFile = $tapa->getFoto();
        // Generate a unique name for the file before saving it
        $fotoFileName = md5(uniqid()).'.'.$fotoFile->guessExtension();

        // Move the file to the directory where brochures are stored
        $fotoFile->move(
            $this->getParameter('foto_directory'),
            $fotoFileName
        );
        // Update the 'brochure' property to store the PDF file name
        // instead of its contents
        $tapa->setFoto($fotoFileName);
        $em = $this->getDoctrine()->getManager();
        $em->persist($tapa);
        $em->flush();
        return $this->redirectToRoute('home_tapas');
      }
      return $this->render('gestion/nuevaTapa.html.twig',array('form'=>$form->createView(),'urlFoto'=>$urlFoto));
    }
    /**
     * @Route("/insertarAdmin",name="gestion_insertar")
     */
    public function insertarAdminAction()
    {
      $usuario=new Usuario();
      $password = $this->get('security.password_encoder')
          ->encodePassword($usuario, '1234');
      $usuario->setPassword($password);
      $usuario->setRoles(['ROLE_ADMIN']);
      $usuario->setUsername('admin');
      $em = $this->getDoctrine()->getManager();
      $em->persist($usuario);
      $em->flush();
      return $this->render('gestion/index.html.twig');
    }
    /**
     * @Route("/reservas",name="gestion_reservas")
     */
    public function reservasAction()
    {
      //listamos todas las reservas
      $em = $this->getDoctrine()->getManager();
      $reservas = $em->getRepository(Reserva::class)->findAll();
      return $this->render('gestion/reservas.html.twig',array('reservas'=>$reservas));
    }
    /**
     * @Route("/aceptarReserva/{id}",name="gestion_aceptarReserva")
     */
    public function aceptarReservaAction($id=null)
    {
      if($id!=null){
        $em = $this->getDoctrine()->getManager();
        $reserva = $em->getRepository(Reserva::class)->find($id);
        $reserva->setAceptada(true);
        $em->persist($reserva);
        $em->flush();
      }
      return $this->redirectToRoute('gestion_reservas');
    }
    /**
     * @Route("/borrarReserva/{id}",name="gestion_borrarReserva")
     */
    public function borrarReservaAction($id=null)
    {
      if($id!=null){
        $em = $this->getDoctrine()->getManager();
        $reserva = $em->getRepository(Reserva::class)->find($id);
        $em->remove($reserva);
        $em->flush();
      }
      return $this->redirectToRoute('gestion_reservas');
    }
    /**
     * @Route("/reserva/{id}",name="gestion_reserva")
     */
    public function reservaAction(Request $request,$id=null)
    {
      $em = $this->getDoctrine()->getManager();
      if($id==null){
        //Comprobamos si el usuario tiene una reserva activa
        $repository = $em->getRepository(Reserva::class);
        $reserva = $repository->findOneBy(
                    array('cliente' => $this->getUser(), 'aceptada' => 0)
                  );
        if(count($reserva)==0)
        {
          $reserva = new Reserva();
        }
      }else{
        $reserva = $em->getRepository(Reserva::class)->find($id);
      }
      $reserva->setCliente($this->getUser());
      $form = $this->createForm(ReservaType::class, $reserva,['cliente' => $this->getUser()->getUsername()]);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $reserva = $form->getData();
        $reserva->setCliente($this->getUser());
        $reserva->setAceptada(false);
        $em->persist($reserva);
        $em->flush();
        return $this->redirectToRoute('gestion_reserva',['id'=>$reserva->getId()]);
      }
      return $this->render('gestion/reserva.html.twig',array('form'=>$form->createView()));
    }
    /**
     * @Route("/registro", name="gestion_registro")
     */
    public function registerAction(Request $request)
    {
        // 1) build the form
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($usuario, $usuario->getPlainPassword());
            $usuario->setPassword($password);
            $usuario->setUsername($usuario->getTelefono());
            $usuario->setRoles(['ROLE_CLIENTE']);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('gestion_login');
        }

        return $this->render(
            'gestion/registro.html.twig',
            array('form' => $form->createView())
        );
    }
}
