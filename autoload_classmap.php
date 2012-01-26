<?php
/**
 * FuelGithub.
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@4expressions.com so I can send you a copy immediately.
 *
 * @category   FuelGithub
 * @copyright  Copyright (c) 2012 Dennis Winter <info@4expressions.com>
 * @license    New BSD License
 */

return array(
    'FuelGithub\Module'                                    => __DIR__ . '/Module.php',
    'FuelGithub\Client\GithubClient'                       => __DIR__ . '/src/FuelGithub/Client/GithubClient.php',
    'FuelGithub\Client\User'                               => __DIR__ . '/src/FuelGithub/Client/User.php',
    'FuelGithub\Client\User\Email'                         => __DIR__ . '/src/FuelGithub/Client/User/Email.php',
    'FuelGithub\Client\Exception'                          => __DIR__ . '/src/FuelGithub/Client/Exception.php',
    'FuelGithub\Client\Exception\InvalidArgumentException' => __DIR__ . '/src/FuelGithub/Client/Exception/InvalidArgumentException.php',
    'FuelGithub\Client\Exception\RuntimeException'         => __DIR__ . '/src/FuelGithub/Client/Exception/RuntimeException.php',
    'FuelGithub\Client\Exception\BadCredentialException'   => __DIR__ . '/src/FuelGithub/Client/Exception/BadCredentialException.php',
);