<?php
namespace Application\Entity\Listener;

use Application\Entity\Property;
use Application\Entity\FeedProductProperty;

class PropertyListener
{

    public function preUpdate(Property $property, \Doctrine\ORM\Event\PreUpdateEventArgs $event)
    {
//         \Doctrine\Common\Util\Debug::dump($property);
//         \Doctrine\Common\Util\Debug::dump($event);
//         die('123');
    }
}