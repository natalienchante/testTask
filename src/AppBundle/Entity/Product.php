<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tblProductData")
 */
class Product
{
    /**
     * @ORM\Column(name="intProductDataId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="strProductName", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(name="strProductDesc", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @ORM\Column(name="strProductCode", type="string", length=10, nullable=false)
     */
    private $productCode;

    /**
     * @ORM\Column(name="dtmAdded", type="datetime")
     */
    private $dateTimeAdded;

    /**
     * @ORM\Column(name="dtmDiscontinued", type="datetime")
     */
    private $dateTimeDiscontinued;

    /**
     * @ORM\Column(name="stmTimestamp", type="datetime")
     */
    private $timestamp;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set productCode
     *
     * @param string $productCode
     *
     * @return Product
     */
    public function setProductCode($productCode)
    {
        $this->productCode = $productCode;

        return $this;
    }

    /**
     * Get productCode
     *
     * @return string
     */
    public function getProductCode()
    {
        return $this->productCode;
    }

    /**
     * Set dateTimeAdded
     *
     * @param \DateTime $dateTimeAdded
     *
     * @return Product
     */
    public function setDateTimeAdded($dateTimeAdded)
    {
        $this->dateTimeAdded = $dateTimeAdded;

        return $this;
    }

    /**
     * Get dateTimeAdded
     *
     * @return \DateTime
     */
    public function getDateTimeAdded()
    {
        return $this->dateTimeAdded;
    }

    /**
     * Set dateTimeDiscontinued
     *
     * @param \DateTime $dateTimeDiscontinued
     *
     * @return Product
     */
    public function setDateTimeDiscontinued($dateTimeDiscontinued)
    {
        $this->dateTimeDiscontinued = $dateTimeDiscontinued;

        return $this;
    }

    /**
     * Get dateTimeDiscontinued
     *
     * @return \DateTime
     */
    public function getDateTimeDiscontinued()
    {
        return $this->dateTimeDiscontinued;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return Product
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
