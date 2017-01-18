<?php namespace Nt\Messager\Traits;

use Nt\Messager\Notify;

trait MessagerCreator {

    /**
     * @param $content
     * @param $sender_id
     *
     * @return \Nt\Messager\Notify
     */
    public static function createAnnounce( $content, $sender_id )
    {
        $type = Notify::ANNOUNCE_TYPE;
        return self::createNotify( compact( 'content', 'sender_id', 'type' ) );
    }

    /**
     * @param $attributes

     *
     * @return \Nt\Messager\Notify
     */
    public static function createNotify( $attributes )
    {
        return Notify::create( $attributes );
    }

    /**
     * @param $target_id
     * @param $target_type
     * @param $action
     * @param $sender_id
     * @param $content
     *
     * @return \Nt\Messager\Notify
     */
    public static function createRemind( $target_id, $target_type, $action, $sender_id, $content )
    {
        $type = Notify::REMIND_TYPE;
        return self::createNotify( compact( 'type',
                                            'target_id',
                                            'target_type',
                                            'action',
                                            'sender_id',
                                            'content' ) );
    }

    /**
     * @param $content
     * @param $sender_id
     * @param $target_id
     *
     * @return \Nt\Messager\Notify
     */
    public static function createMessage( $content, $sender_id, $target_id )
    {
        $type = Notify::MESSAGE_TYPE;
        $target_type = 'user';
        return self::createNotify( compact( 'type',
                                            'target_id',
                                            'sender_id',
                                            'target_type',
                                            'content' ) );
    }

}