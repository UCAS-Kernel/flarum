<?php

/*
* This file is part of Flarum.
*
* For detailed copyright and license information, please view the
* LICENSE file that was distributed with this source code.
*/
// For restoring viewer's real ip
// May cause some warnings but it don't matter
$_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
use Flarum\Extend;
use Flarum\Foundation\ValidationException;
use Flarum\User\Event\Saving;
use Illuminate\Support\Arr;
// only register with 'mails.ucas.ac.cn' is allowed
// if you want to register with other domains, please modify the following code
return [
    // Register extenders here to customize your forum!
        (new Extend\Event())
                ->listen(Saving::class, function (Saving $event) {
                        $email=Arr::get($event->data, 'attributes.email');
                        if ((preg_match("/^[a-zA-Z0-9_-]+@mails.ucas.ac.cn$/",$email)!=1 && preg_match("/^[a-zA-Z0-9_-]+@mails.ucas.edu.cn$/",$email)!=1)&& !empty($email)){
                                throw new ValidationException(["请使用学校邮箱"]);
                        }
                }),
];