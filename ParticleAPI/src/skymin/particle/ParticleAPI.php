<?php
declare(strict_types = 1);

namespace skymin\particle;

use pocketmine\Server;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

use skymin\particle\task\{
	CircleAsyncTask,
	StraightAsyncTask,
	RegularAsyncTask
};

final class ParticleAPI{
	
	/*circle type*/
	public const SIN = 0;
	public const COS = 1;
	
	public static function drawCircle(int $ParticleId, Vector3 $center, float $radius, float $unit, array $players, int $color = 0, float $slope = 0, int $type = self::SIN, float $angle = 0.0) :void{
		Server::getInstance()->getAsyncPool()->submitTask(new CircleAsyncTask($ParticleId, $center->x, $center->y, $center->z, $radius, $unit, $players, $color, $slope, $type, $angle));
	}
	
	public static function drawStraight(int $ParticleId, Vector3 $pos1, Vector3 $pos2, float $unit, array $players, int $color = 0) :void{
		Server::getInstance()->getAsyncPool()->submitTask(new StraightAsyncTask($ParticleId, $pos1->x, $pos1->y, $pos1->z, $pos2->x, $pos2->y, $pos2->z, $unit, $players, $color));
	}
	
	public static function drawRegular(int $ParticleId, Vector3 $center, float $radius, int $side, float $unit, float $angle, array $players, int $color = 0) :void{
		Server::getInstance()->getAsyncPool()->submitTask(new RegularAsyncTask($ParticleId, $center->x, $center->y, $center->z, $radius, $side, $unit, $angle, $players, $color));
	}
	
}