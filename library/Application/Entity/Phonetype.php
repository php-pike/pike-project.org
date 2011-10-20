<?php
namespace Application\Entity;

/**
 * @Table(name="phonetype")
 * @Entity
 */
class Phonetype
{
    /**
     * 
     * @var integer
     * 
     * @Column(type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */    
    protected $id;
    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
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
