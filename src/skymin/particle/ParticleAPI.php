<?php
declare(strict_types = 1);

namespace skymin\particle;

use pocketmine\Server;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

use function atan2;
use function cos;
use function deg2rad;
use function mt_rand;
use function rad2deg;
use function sin;
use function sqrt;

function circle(int $ParticleId, Vector3 $center, float $radius, float $unit, int $color, float $slope, int $type, float $angle) :array{
	$packets = array();
	$x = $center->x;
	$y = $center->y;
	$z = $center->z;
	for ($i = 0; $i < 360; $i += $unit){
		if($type === 0){
			$vec = new Vector3($x + sin(deg2rad($i)) * $radius, $y + (sin(deg2rad($i + $angle))) * $slope, $z + cos(deg2rad($i)) * $radius);
		}
		if($type === 1){
			$vec = new Vector3($x + sin(deg2rad($i)) * $radius, $y + cos(deg2rad($i + $angle)) * $slope, $z + cos(deg2rad($i)) * $radius);
		}
		$packets[] = LevelEventPacket::standardParticle($ParticleId, $color, $vec);
	}
	return $packets;
}

class ParticleAPI{
	
	public const SIN = 0;
	public const COS = 1;
	
	public static function drawCircle(int $ParticleId, Vector3 $center, float $radius, float $unit,  array $players, int $color = 0, float $slope = 0, int $type = self::SIN, float $angle = 0.0) :void{
		$packets = circle($ParticleId, $center, $radius, $unit, $color, $slope, $type, $angle);
		Server::getInstance()->broadcastPackets($players, $packets);
	}
	
}