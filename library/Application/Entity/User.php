<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * 
 * @ORM\Entity
 * @ORM\HasLifeCycleCallbacks
 */
class User extends Basic
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
     * @ORM\Column(type="string",nullable=false)	 
     */
    protected $username;    
    
    /**
     *
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    protected $password;    
}

?>
