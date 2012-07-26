<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * 
 * @ORM\Entity
 */
class ContentItem extends Basic
{

    /**
     * 
     * @var string
     * 
     * @ORM\Column(type="string",nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $id;
    
    /**
     *
     * @var string
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $abstract;
    
    /**
     * 
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    protected $pageTitle;
    
    /**
     *
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    protected $title;
    
    /**
     *
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $metaDescription;
    
    /**
     *
     * @var string
     * @ORM\Column(type="text", nullable=false)
     */
    protected $content;

}

?>
