<?php

namespace TapasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use TapasBundle\Entity\Tapa;

class DefaultController extends Controller
{
    /**
     * @Route("/",name="home")
     */
    public function indexAction()
    {
        $tapas= $this->getDoctrine()
        ->getRepository(Tapa::class)
        ->findByTop(1);
        return $this->render('tapas/index.html.twig',array('tapas'=>$tapas));
    }
    /**
     * @Route("/nosotros",name="home_nosotros")
    */
    public function nosotrosAction()
    {
      return $this->render('tapas/nosotros.html.twig');
    }
    /**
     * @Route("/contactar/{sitio}",name="home_contactar")
    */
    public function contactarAction($sitio="todos")
    {
      return $this->render('tapas/bares.html.twig',array("sitio"=>$sitio));
    }
    /**
     * @Route("/tapas/{currentPage}",name="home_tapas")
    */
    public function tapasAction($currentPage = 1)
    {
      $limit=3;
      $repository = $this->getDoctrine()->getRepository(Tapa::class);
      $tapas = $repository->allTapas($currentPage, $limit);
      $tapasResultado = $tapas['paginator'];
      $tapasQueryCompleta =  $tapas['query'];

      $maxPages = ceil($tapas['paginator']->count() / $limit);

      return $this->render('tapas/tapas.html.twig', array(
            'tapas' => $tapasResultado,
            'maxPages'=>$maxPages,
            'thisPage' => $currentPage,
            'all_items' => $tapasQueryCompleta
        ) );
    }
    /**
     * @Route("/tapa/{id}",name="home_tapa")
    */
    public function tapaAction($id=1)
    {
      $repository = $this->getDoctrine()->getRepository(Tapa::class);
      $tapa = $repository->find($id);
      return $this->render('tapas/tapa.html.twig',array("tapa"=>$tapa));
    }
}
