<?php
/*
 *                      _                               
 *  _ __     __ _    __| |  _ __    ___    ___    _ __  
 * | '_ \   / _` |  / _` | | '__|  / _ \  / _ \  | '_ \ 
 * | |_) | | (_| | | (_| | | |    |  __/ | (_) | | | | |
 * | .__/   \__,_|  \__,_| |_|     \___|  \___/  |_| |_|
 * |_|                                                  
 *
 * Created by PhpStorm.
 * Date: 11/07/2019
 * Time: 20.37
 */
namespace padreon\CreativeLimit;

use pocketmine\block\Block;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerGameModeChangeEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onInteract(PlayerInteractEvent $event){
        $player = $event->getPlayer();
        $blocks = $event->getBlock()->getId();
        $blacklist = [Block::ENDER_CHEST, Block::CHEST, Block::FURNACE, Block::BURNING_FURNACE, Block::TRAPPED_CHEST, Block::ENCHANTMENT_TABLE, Block::ANVIL, Block::ITEM_FRAME_BLOCK, Block::SHULKER_BOX, Block::UNDYED_SHULKER_BOX];
        //$blacklist = [130, 54, 61, 146, 116, 145, 199, 325];
        if ($player->isCreative()){
            if (in_array($blocks, $blacklist)){
                $event->setCancelled();
                return;
            }
        }
    }


    public function onGameModeChange(PlayerGameModeChangeEvent $event){
        $player = $event->getPlayer();
        $newGM = $event->getNewGamemode();
        if ($newGM === 0){
            $player->getInventory()->clearAll();
            $player->getArmorInventory()->clearAll();
            return;
        }
    }

    public function onDropItem(PlayerDropItemEvent $event)
    {
        $player = $event->getPlayer();
        if ($player->isCreative()){
            $event->setCancelled();
        }
    }

    public function onPlayerDeath(PlayerDeathEvent $event){
        $player = $event->getPlayer();
        if ($player->isCreative()){
            $player->getInventory()->clearAll();
            $player->getArmorInventory()->clearAll();
        }
    }

    public function onAttack(EntityDamageEvent $event){
        if ($event instanceof EntityDamageByEntityEvent){
            $player = $event->getDamager();
            if ($player instanceof Player){
                if ($player->isCreative()) {
                    $event->setCancelled();
                }
            }
        }
    }



}
