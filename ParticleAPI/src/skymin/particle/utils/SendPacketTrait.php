<?php
declare(strict_types = 1);

namespace skymin\particle\utils;

use pocketmine\Server;

use pocketmine\network\mcpe\compression\ZlibCompressor;
use pocketmine\network\mcpe\protocol\serializer\{PacketSerializerContext, PacketBatch};
use pocketmine\network\mcpe\convert\GlobalItemTypeDictionary;

trait SendPacketTrait{
	
	public function onCompletion() :void{
		$result = (array)$this->getResult();
		$server = Server::getInstance();
		$batch = $server->prepareBatch(PacketBatch::fromPackets(new PacketSerializerContext(GlobalItemTypeDictionary::getInstance()->getDictionary()), ...$result), ZlibCompressor::getInstance());
		foreach ($this->targets as $name){
			$target = $server->getPlayerExact($name);
			if($target === null) continue;
			$target->getNetworkSession()->queueCompressed($batch);
		}
	}
	
}