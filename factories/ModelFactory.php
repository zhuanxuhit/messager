<?php
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define( \Nt\Messager\Notify::class, function ( Faker\Generator $faker ) {
    $content     = $faker->text;
    $type        = $faker->randomElement( [ 1, 2, 3 ] );
    $target_id   = $faker->randomNumber();
    $sender_id   = $faker->randomNumber();
    $target_type = $faker->randomElement( \Nt\Messager\Notify::TARGET_TYPEs );
    $action      = $faker->randomElement( \Nt\Messager\Notify::ACTION_TYPES );
    return compact( 'content', 'type', 'target_id', 'target_type', 'sender_id', 'action' );
} );

$factory->define( \Nt\Messager\UserNotify::class, function ( Faker\Generator $faker ) {
    //    $user_id = $faker->randomNumber();
    $user_id     = $faker->numberBetween( 1, 4 );
    $notify_id   = $faker->randomNumber();
    $notify_type = $faker->randomElement( [ 1, 2, 3 ] );
    return compact( 'user_id', 'notify_id', 'notify_type' );
} );
$factory->define( \Nt\Messager\Subscription::class, function ( Faker\Generator $faker ) {
    $user_id     = $faker->numberBetween( 1, 4 );
    $target_id   = $faker->randomNumber();
    $target_type = $faker->randomElement( \Nt\Messager\Notify::TARGET_TYPEs );
    $action      = $faker->randomElement( \Nt\Messager\Notify::ACTION_TYPES );
    return compact( 'user_id', 'target_id', 'target_type', 'action' );
} );