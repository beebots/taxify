<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/22/15
 * Time: 10:31 AM
 */

namespace rk\Taxify;

class Taxify
{

    public const VERSION = '1.0.1';

    public const DEV_URL  = 'https://ws-test.shipcompliant.com/taxify/1.1/core/JSONservice.asmx/';
    public const PROD_URL = 'https://ws.taxify.co/taxify/1.1/core/JSONService.asmx/';
    public const ENV_DEV  = 'DEV';
    public const ENV_PROD = 'PROD';

    private $environment = self::ENV_PROD;
    private $api_key;
    private $debug_mode = false;

    /**
     * @param null       $api_key
     * @param null       $environment
     * @param bool|FALSE $debug_mode
     */
    public function __construct($api_key = null, $environment = null, $debug_mode = false)
    {
        if ($api_key !== null) {
            $this->setApiKey($api_key);
        }

        $this->setDebugMode($debug_mode);

        if ($environment !== null) {
            $this->setEnvironment($environment);
        }

        if ($this->isDev()) {
            trigger_error('The Taxify API does not have a dev endpoint that I can find; testing may fail!', E_USER_WARNING);
        }
    }

    public function isProd(): bool
    {
        return $this->environment === self::ENV_PROD;
    }

    public function isDev(): bool
    {
        return $this->environment === self::ENV_DEV;
    }

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    public function setEnvironment($environment)
    {
        $this->environment = $environment === self::ENV_DEV ? self::ENV_DEV : self::ENV_PROD;

        return $this;
    }

    public function getApiKey(): string
    {
        return $this->api_key;
    }

    public function setApiKey(string $api_key)
    {
        $this->api_key = $api_key;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->isProd() ? self::PROD_URL : self::DEV_URL;
    }

    public function isDebugMode(): bool
    {
        return $this->debug_mode;
    }

    public function setDebugMode(bool $debug_mode)
    {
        $this->debug_mode = $debug_mode;

        return $this;
    }

    public function printDebugInfo(string $title, $data): bool
    {
        if ($this->debug_mode) {
            echo $title, PHP_EOL, str_repeat('=', strlen($title)), PHP_EOL, PHP_EOL;

            if (is_string($data)) {
                echo $data, PHP_EOL;
            } else {
                var_export($data);
            }

            echo PHP_EOL;

            return true;
        }

        return false;
    }
}