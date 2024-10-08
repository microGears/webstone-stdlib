<?php

declare(strict_types=1);
/**
 * This file is part of microGears\Stdlib.
 *
 * (C) 2009-2024 Maxim Kirichenko <kirichenko.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WebStone\Stdlib\Classes;

use WebStone\Stdlib\Helpers\StringHelper;

trait InitTrait
{
    /**
     * Initializes the object with the given configuration and context.
     *
     * @param array $config The configuration options.
     * @param mixed $context The context for initialization.
     * @return void
     */
    public function initialize(array $config = [], $context = null)
    {
        if ($context == null || !is_object($context)) {
            $context = &$this;
        }

        if (count($config)) {
            foreach ($config as $key => $val) {
                if (is_numeric($key)) {
                    continue;
                }

                if (method_exists($context, $method = 'set' . StringHelper::normalizeName($key))) {
                    call_user_func([$context, $method], $val);
                } else {

                    if (strpos(phpversion(), '8.2') === 0 && !property_exists($context, $key)) {
                        throw new \Exception(sprintf('Class  "%s" does not have the "%s" property, dynamic creation of properties is not supported since version 8.2', StringHelper::className($context, false), $key));
                    }

                    $context->{$key} = $val;
                }
            }
        }
    }
}
