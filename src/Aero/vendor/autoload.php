<?php

require dirname ( __FILE__, 2 ) . DIRECTORY_SEPARATOR . 'AeroBase.php';

class Aero extends Aero\AeroBase {}

spl_autoload_register ( [ Aero::class, 'autoload' ] );

print_r ( Aero::AppCore( Aero\Main::class, Aero\Massive::class ) -> run() );