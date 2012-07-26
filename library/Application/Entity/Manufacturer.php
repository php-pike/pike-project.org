<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Table(name="manufacturer")
 * @ORM\Entity
 */
class Manufacturer extends Basic
{
    /**
     * 
     * @var integer
     * 
     * @ORM\Column(type="integer",nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */    
    protected $id;
    /**
     *
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;
}

?>
