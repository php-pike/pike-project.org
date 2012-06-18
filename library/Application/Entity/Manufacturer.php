<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Table(name="manufacturer")
 * @ORM\Entity
 */
class Manufacturer
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
    
    public function __get($key) {
        return $this->$key;
    }
    
    public function __set($key, $value) {
        $this->$key = $value;
    }
}

?>
