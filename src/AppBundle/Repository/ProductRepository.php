<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
//    public function insertProductsFromCSV()
//    {
//        return $this->getEntityManager()
//            ->createQuery(
//                'INSERT INTO tblProductData (strProductName, strProductDesc, intProductStock, numProductPrice, strProductCode,
//                dtmAdded, dtmDiscontinued) VALUES (:name, :description, :stock, :price, :code, :timeAdded, :timeDiscontinued)'
//            )
//            ->getResult();
//    }
}