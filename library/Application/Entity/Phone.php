<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * 
 * @ORM\Table(name="phone")
 * @ORM\Entity
 */
class Phone
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
     * @var integer
     * @ORM\Column(type="integer",nullable=false)	 
     */
    protected $weight;    
    
    /**
     *
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;
    
    /**
     * Batterylife in hours
     * 
     * @var integer
     * @ORM\Column(type="integer",nullable=false)	 
     */    
    protected $batterylife;
    
    /**
     * @ORM\ManyToOne(targetEntity="Phonetype", cascade={"all"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */    
    protected $phonetype;
    
    /**
     * @ORM\ManyToOne(targetEntity="Manufacturer", cascade={"all"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $manufacturer;
    
    public function __get($key) {
        return $this->$key;
    }
    
    public function __set($key, $value) {
        $this->$key = $value;
    }    
}

?>
