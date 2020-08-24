<?php
namespace App\EventListener;
use Doctrine\cammon\EventSubscriber;

class Suscriber implements EventSubscriber
{   
    public function getSubscriberEvent()
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove
        ];
       
    }

    public function postPersist(LifecycleEventArgs $args){

    }
    public function postUpdate(LifecycleEventArgs $args){
        
    }
    public function postRemove(LifecycleEventArgs $args){
        
    }

}