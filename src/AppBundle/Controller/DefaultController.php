<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ParserForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use \KzykHys\CsvParser\CsvParser;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $parser = new ParserForm();
        $form = $this->createFormBuilder($parser)
            ->add('filename', TextType::class)
            ->add('file', FileType::class)
            ->add('add', SubmitType::class)
            ->getForm();


        //$parser = CsvParser::fromFile('./');
        //$result = $parser->parse();
        // replace this example code with whatever you need
        return $this->render('default/parse.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
