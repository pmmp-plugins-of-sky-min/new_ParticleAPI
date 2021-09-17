# new_ParticleAPI
virion project

# HOW TO USE
## Variable Description
$ParticleId : int : [ParticleIds](https://github.com/pmmp/BedrockProtocol/blob/master/src/types/ParticleIds.php)

$center, $pos1, $pos2 : Vector3

$unit : float : Particle spacing

$players : array : Players who can see particles.

$color : int : [Color](https://github.com/pmmp/Color/blob/master/src/Color.php)->toARGB()

$slope : float

$type : int : ParticleAPI::SIN or ParticleAPI::COS. this is trig(trigonometric) ratio. 'I felt the need due to the slope and angle.'

$angle : float : direction or angle

$radius : float : Distance from the center

$side : int : number of vertices. 3 or higher

## Draw Particle

### linked for use
```php
use skymin\particle\ParticleAPI;
```

### draw circle particle
```php
ParticleAPI::drawCircle($ParticleId, $center, $radius, $unit, $players, $color, $slope, $type, $angle);
```

### draw straight particle
```php
ParticleAPI::drawStraight($ParticleId, $pos1, $pos2, $unit, $players, $color);
```

### draw regular particle
```php
ParticleAPI::drawRegular($ParticleId, $center, $radius, $side, $unit, $rotation, $players, $color);
```
# Example
[@example](https://github.com/sky-min/new_ParticleAPI/blob/master/example/ParticleTest.php)