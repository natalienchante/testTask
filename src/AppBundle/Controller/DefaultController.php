<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CSVFile;
use AppBundle\Form\CSVFileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $file = new CSVFile();
        $form = $this->createForm(CSVFileType::class, $file)->add('Parse', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileToParse = $file->getFile();

            $parser = $this->get('csv.parser');
            $result = $parser->parseCSVFile($fileToParse);
            print_r($result);
            //$em = $this->getDoctrine()->getManager();

            $columns = implode(',', array_values($result[0]));
            /*foreach ($result as $recordKey => $recordValue) {
                foreach ($recordValue as $key => $value) {
                    $values[] = $value;
                }
                $comma_separated = implode(",", $values);
                $l = $comma_separated.'<hr>';
            }*/
            echo($columns);



            //$em->persist($product);
            //$em->flush();
            return $this->render('default/success.html.twig');
        }

        return $this->render('default/parse.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
