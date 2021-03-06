<?php

namespace milk\entitymanager\entity\monster\walking;

use milk\entitymanager\entity\monster\WalkingMonster;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item;
class Spider extends WalkingMonster{
    const NETWORK_ID = 35;

    public $width = 1.5;
    public $height = 1.2;

    public function getSpeed() : float{
        return 1.13;
    }

    public function initEntity(){
        parent::initEntity();

        $this->setMaxHealth(16);
        $this->setDamage([0, 2, 2, 3]);
    }

    public function getName() : string{
        return "Spider";
    }

    public function attackEntity(Entity $player){
        if($this->attackDelay > 10 && $this->distanceSquared($player) < 1.32){
            $this->attackDelay = 0;
            $ev = new EntityDamageByEntityEvent($this, $player, EntityDamageEvent::CAUSE_ENTITY_ATTACK, $this->getDamage());
            $player->attack($ev->getFinalDamage(), $ev);
        }
    }

    public function getDrops(){
        return $this->lastDamageCause instanceof EntityDamageByEntityEvent ? [Item::get(Item::STRING, 0, mt_rand(0, 3))] : [];
    }

}
