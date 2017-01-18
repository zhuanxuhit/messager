<?php namespace Nt\Messager\Services;

use Nt\Messager\Traits\MessageAccessible;
use Nt\Messager\Traits\MessagerCreator;
use Nt\Messager\Traits\SubscriptionHandler;

class NotifyService {
    use MessagerCreator,MessageAccessible,SubscriptionHandler;
}