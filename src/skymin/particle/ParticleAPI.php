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

function circle(int $ParticleId, Vector3 $center, float $radius, float $unit, int $color, int $direction, float $start, float $finish, float $slope) :array{
  if($start > $finish) $finish += 360;
	$packets = array();
	$x = $center->x;
	$y = $center->y;
	$z = $center->Z;
	if($direction === 0){
		for ($i = 0; $i < 360; $i += $unit){
		if(($angle = $i + $start) > $finish) break;
		$vec = new Vector3($x + sin(deg2rad($angle)) * $radius, $y + (sin(deg2rad($i)) * $slope), $z + cos(deg2rad($angle)) * $radius);
		$packets[] = LevelEventPacket::standardParticle($ParticleId, $color, $vec);
	  }
		return $packets;
	}
	if($direction === 1){
		for ($i = 0; $i < 360; $i += $unit){
			if(($angle = 360 - $i + $start) > $finish) break;
			$vec = new Vector3($x + sin(deg2rad($angle)) * $radius, $y + (sin(deg2rad($i)) * $slope), $z + cos(deg2rad($angle)) * $radius);
			$packets[] = LevelEventPacket::standardParticle($ParticleId, $color, $vec);
		}
		return $packets;
	}
}

class ParticleAPI{
	
	public const RIGHT = 0;
	public const LEFT = 1;
	
	public static function drawCircle(int $ParticleId, Vector3 $center, float $radius, float $unit,  array $players, int $color = 0, int $direction = self::RIGHT, float $start = 0, float $finish = 360, float $slope = 0) :void{
		$packets = circle($ParticleId, $center, $radius, $unit, $color, $direction, $start, $finish, $slope);
		Server::getInstance()->broadcastPackets($players, $packets);
	}
	
}