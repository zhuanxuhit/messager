<?php namespace Nt\Messager\Services;

use Nt\Messager\Traits\MessagerAccessible;
use Nt\Messager\Traits\MessagerCreator;
use Nt\Messager\Traits\SubscriptionHandler;

class NotifyService {
    use MessagerCreator,MessagerAccessible,SubscriptionHandler;
}