<?php

namespace milk\entitymanager\entity\animal\walking;

use milk\entitymanager\entity\animal\WalkingAnimal;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\entity\Creature;

class Chicken extends WalkingAnimal{
    const NETWORK_ID = 10;

    public $width = 0.4;
    public $height = 0.75;

    public function getName() : string{
        return "Chicken";
    }

    public function initEntity(){
        parent::initEntity();

        $this->setMaxHealth(4);
    }

    public function targetOption(Creature $creature, float $distance) : bool{
        if($creature instanceof Player){
            return $creature->isAlive() && !$creature->closed && $creature->getInventory()->getItemInHand()->getId() == Item::SEEDS && $distance <= 49;
        }
        return false;
    }

    public function getDrops(){
        $drops = [];
        if($this->lastDamageCause instanceof EntityDamageByEntityEvent){
            switch(mt_rand(0, 2)){
                case 0 :
                    $drops[] = Item::get(Item::RAW_CHICKEN, 0, 1);
                    break;
                case 1 :
                    $drops[] = Item::get(Item::EGG, 0, 1);
                    break;
                case 2 :
                    $drops[] = Item::get(Item::FEATHER, 0, 1);
                    break;
            }
        }
        return $drops;
    }

}