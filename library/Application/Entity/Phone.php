<?php
namespace Application\Entity;

/**
 * @Table(name="phone")
 * @Entity
 */
class Phone
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
     * @var integer
     * @Column(type="integer",nullable=false)	 
     */
    protected $weight;    
    
    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $name;
    
    /**
     * Batterylife in hours
     * 
     * @var integer
     * @Column(type="integer",nullable=false)	 
     */    
    protected $batterylife;
    
    /**
     * @ManyToOne(targetEntity="Phonetype", cascade={"all"})
     * @JoinColumn(onDelete="CASCADE", onUpdate="CASCADE")
     */    
    protected $phonetype;
    
    /**
     * @ManyToOne(targetEntity="Manufacturer", cascade={"all"})
     * @JoinColumn(onDelete="CASCADE", onUpdate="CASCADE")
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
