# new_ParticleAPI
virion project

# HOW TK USE
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