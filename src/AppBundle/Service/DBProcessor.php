<?php

namespace AppBundle\Service;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;

class DBProcessor
{
    private $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function executeInsert($validatedRecords)
    {
        foreach ($validatedRecords as $record) {
            $product = new Product();
            $product->setName($record[1])
                ->setDescription($record[2])
                ->setStock($record[3])
                ->setPrice($record[4])
                ->setProductCode($record[0])
                ->setDateTimeAdded(new \DateTime())
                ->setDateTimeDiscontinued($this->checkDiscontinued($record[5]));
            $this->em->persist($product);
        }

        $this->em->flush();
    }

    private function checkDiscontinued($value)
    {
        return !empty($value) ? new \DateTime() : null;
    }
}