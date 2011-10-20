<?php
/**
 * Data fixtures to fill up the database
 */

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment, (I am only running this in development)
define('APPLICATION_ENV', 'development');

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Creating application
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

// Bootstrapping resources
$bootstrap = $application->bootstrap()->getBootstrap();
$bootstrap->bootstrap('Doctrine');

// Retrieve Doctrine Container resource
$container = $application->getBootstrap()->getResource('doctrine');

/* @var $em Doctrine\ORM\EntityManager */
$em = $container->getEntityManager();

$em->createQuery('DELETE FROM Application\Entity\Phone')->execute();
$em->createQuery('DELETE FROM Application\Entity\Phonetype')->execute();

$phonetypes = array('smartphone', 'simplephone', 'windows 7', 'android');

foreach($phonetypes as &$phonetype) {
    $entity = new Application\Entity\Phonetype();
    $entity->name = $phonetype;
    
    $phonetype = $entity;   
}

$phones = array(
    "Apple iPhone 4 16 GB",
    "Apple iPhone 4 32 GB",
    "Nokia 1616",
    "Nokia 2700",
    "Nokia 2710",
    "Nokia 2730 Classic",
    "Nokia 3720c",
    "Nokia 5230",
    "Nokia 6303i",
    "Nokia 6700 Slide",
    "Nokia C1-01",
    "Nokia C1-02",
    "Nokia C2-01",
    "Nokia C3-00",
    "Nokia 7230",
    "Nokia C3-01",
    "Nokia C5-00",
    "Nokia C5-03",
    "Nokia C6",
    "Nokia C6-01",
    "Nokia C7-00",
    "Nokia E5-00",
    "Nokia E52",
    "Nokia E6-00",
    "Nokia E7-00 QWERTY",
    "Nokia E72",
    "Nokia N8",
    "Nokia X2",
    "Nokia X3-02",
    "Nokia X7-00",
    "HTC ChaCha",
    "HTC Desire",
    "HTC Desire HD",
    "HTC Desire S",
    "HTC Desire Z",
    "HTC Evo 3D",
    "HTC Incredible S",
    "HTC Legend",
    "HTC Radar",
    "HTC Sensation",
    "HTC Sensation Vodafone",
    "HTC Smart",
    "HTC Titan",
    "HTC Wildfire",
    "HTC Wildfire S",
    "HTC 7 Trophy",
    "BlackBerry Bold 9000 Vodafone",
    "BlackBerry Bold 9780 QWERTY",
    "BlackBerry Bold 9780 T-Mobile",
    "BlackBerry Bold 9900",
    "BlackBerry Curve 9300 T-Mobile Prepaid",
    "BlackBerry Curve 8520 KPN Prepaid",
    "BlackBerry Curve 8520 QWERTY",
    "BlackBerry Curve 8520 T-Mobile Prepaid",
    "BlackBerry Curve 8520 Hi Prepaid",
    "BlackBerry Curve 8520 Vodafone Prepaid",
    "BlackBerry Curve 9300 QWERTY",
    "BlackBerry Curve 9300 Hi Prepaid",
    "BlackBerry Curve 9300 KPN Prepaid",
    "BlackBerry Curve 9360",
    "BlackBerry Pearl 3G",
    "BlackBerry Torch 9800",
    "BlackBerry Torch 9800 T-Mobile",
    "BlackBerry Torch 9860",
    "BlackBerry Bold 9000",
    "Nexus S",
    "Samsung B2100",
    "Samsung B5722",
    "Samsung C3530",
    "Samsung Ch@t 322",
    "Samsung Ch@t 322 T-Mobile Prepaid",
    "Samsung Ch@t 335 Hi Prepaid",
    "Samsung Ch@t 335 Telfort Prepaid",
    "Samsung Ch@t 335",
    "Samsung Ch@t 335 Vodafone Prepaid",
    "Samsung E2152 DualSim",
    "Samsung Galaxy Ace",
    "Samsung Galaxy Gio",
    "Samsung Galaxy Mini",
    "Samsung Galaxy S Armani",
    "Samsung Galaxy S 8GB",
    "Samsung Galaxy S II",
    "Samsung Galaxy S Plus",
    "Samsung E2370",
    "Samsung E2550",
    "Samsung Omnia 7",
    "Samsung Omnia 735",
    "Samsung S5230 Star-NFC",
    "Samsung S5250 Hi Prepaid",
    "Samsung Star II",
    "Samsung Star Mini",
    "Samsung Star",
    "Samsung Wave II",
    "Samsung Wave S7230",
    "Samsung B2710",
    "Sony Ericsson Cedar",
    "Sony Ericsson Spiro",
    "Sony Ericsson Vivaz Pro",
    "Sony Ericsson Xperia Arc",
    "Sony Ericsson Xperia Mini",
    "Sony Ericsson Xperia Mini Pro",
    "Sony Ericsson Xperia Neo",
    "Sony Ericsson Xperia Play",
    "Sony Ericsson X10 Mini Pro",
    "Sony Ericsson X8",
    "Sony Ericsson Yendo",
    "LG C300",
    "LG C300 Vodafone Prepaid",
    "LG GX200 Dual Sim",
    "LG Optimus 3D Speed",
    "LG Optimus Black",
    "LG P350 Optimus Me Hi Prepaid",
    "LG P350 Optimus Me Vodafone Prepaid",
    "LG Optimus One",
    "LG Optimus 2X Speed",
    "Huawei IDEOS",
    "Huawei IDEOS X5",
    "Acer BeTouch E210",
    "ACER Iconia Smart",
    "Acer Liquid E S100",
    "Acer Liquid Metal S120",
    "Acer Liquid Mini",
);

foreach($phones as $phone) {
    $parts = explode(' ', $phone);
    
    $manufacturer = $parts[0];
    $manufacturer = $em->getRepository('Application\Entity\Manufacturer')->findOneBy(array('name' => strtolower($manufacturer)));
    
    if(null === $manufacturer) {
        $manufacturer = new Application\Entity\Manufacturer();
        $manufacturer->name = strtolower($parts[0]);             
    }
        
    $phonetype = $phonetypes[array_rand($phonetypes)];    
    
    $entity = new Application\Entity\Phone();
    $entity->manufacturer = $manufacturer;
    $entity->name = $phone;
    $entity->phonetype = $phonetype;
    $entity->batterylife = rand(6, 16);
    $entity->weight = rand(90, 415);
    
    $em->persist($entity);
}

$em->flush();
?>