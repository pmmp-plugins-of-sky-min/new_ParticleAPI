<?php
declare(strict_types = 1);

namespace skymin\particle\utils;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

use function cos;
use function deg2rad;
use function sin;

trait CircleTrait{
	
	private function circle(int $ParticleId, Vector3 $center, float $radius, float $unit, int $color, float $slope, int $type, float $angle) :array{
		$packets = array();
		$x = $center->x;
		$y = $center->y;
		$z = $center->z;
		if($type === 0){
			for ($i = 0; $i < 360; $i += $unit){
				$a = $i + $angle;
				$vec = new Vector3($x + sin(deg2rad($a)) * $radius, $y + (sin(deg2rad($a))) * $slope, $z + cos(deg2rad($a)) * $radius);
				$packets[] = LevelEventPacket::standardParticle($ParticleId, $color, $vec);
			}
		}else if($type === 1){
			for ($i = 0; $i < 360; $i += $unit){
				$a = $i + $angle;
				$vec = new Vector3($x + sin(deg2rad($a)) * $radius, $y + cos(deg2rad($a)) * $slope, $z + cos(deg2rad($a)) * $radius);
				$packets[] = LevelEventPacket::standardParticle($ParticleId, $color, $vec);
			}
		}
		return $packets;
	}
	
}