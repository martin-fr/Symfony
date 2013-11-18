<?php

namespace Dreams\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DreamsUserBundle extends Bundle {

    public function getParent()
    {
        return 'FOSUserBundle';
    }

}
