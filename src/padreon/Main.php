<?php
namespace padreon;
 
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\ItemBlock;
use pocketmine\command\PluginCommand;
use pocketmine\permission\Permission;
use pocketmine\utils\TextFormat;
use pocketmine\command\CommandExecutor;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
 
class Main extends PluginBase implements Listener{
       
 
        public function onLoad(){
                    $this->getLogger()->info("Plugin Loading");
        }
        public function onEnable(){
            $this->getServer()->getPluginManager()->registerEvents($this, $this);
                    $this->getLogger()->info("Enabled Plugin");
        }
        public function onDisable(){
                    $this->getLogger()->info("Plugin Disabled");
        }
 
   
        public function onInteract(PlayerInteractEvent $ev){
        $chest = 54; //Id Chest
        if(($ev->getPlayer()->getGamemode() === 1) && ($ev->getBlock()->getId() === $chest)) $ev->setCancelled();
 
        }
		public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
			$cmd = strlower($command->getName()):
			switch($cmd){
    
				case "creative":
                if (!($sender instanceof Player)){
                    $sender->sendMessage($this->consoleMsg);
                    return true;
                }
                $player = $this->getServer()->getPlayer($sender->getName());
                
                if ($player->hasPermission("limit.creative")){
                    if ($player->getGamemode() == 1){
                        $player->sendMessage(TextFormat::RED."You are already in creative mode!");
                    } else {
                        $player->setGamemode(1);
                        $player->sendMessage(TextFormat::GREEN."You are now in creative mode!");
						$player->getInventory()->clearAll();
                    }
                    return true;
                    
                } else {
                    $player->sendMessage($this->permMessage);
                    return true;
                }
                break;

      
				case "survival":
				  
				 if (!($sender instanceof Player)){
                    $sender->sendMessage($this->consoleMsg);
                    return true;
                }
                $player = $this->getServer()->getPlayer($sender->getName());
                
                if ($player->hasPermission("limit.survival")){
                    if ($player->getGamemode() == 1){
                        $player->sendMessage(TextFormat::RED."You are already in creative mode!");
                    } else {
                        $player->setGamemode(1);
                        $player->sendMessage(TextFormat::GREEN."You are now in creative mode!");
						$player->getInventory()->clearAll();
                    }
                    return true;
                    
                } else {
                    $player->sendMessage($this->permMessage);
                    return true;
                }
                break;
			}
		}
}
