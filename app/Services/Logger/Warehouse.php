<?php

namespace App\Services\Logger;

use App\Jobs\SendLogToWarehouse;

class Warehouse
{
    /** Log Level Critical */
    const LOG_CRITICAL = 'critical';
    const LOG_CRITICAL_CODE = 1;

    /** Log Level Warning */
    const LOG_WARNING = 'warning';
    const LOG_WARNING_CODE = 2;

    /** Log Level Info */
    const LOG_INFO = 'info';
    const LOG_INFO_CODE = 3;

    /** URI for HTTP request */
    const API_URI = 'localhost:8082/v1/log';

    /** API AUTHENTICATION */
    const API_AUTH = 'abs';

    /** @var null $content */
    private static $content;

    /** @var string $log_name */
    private static $log_name = 'log_default';

    /** @var string|int $identifier Identificador para facilitar busca do log */
    private static $identifier;

    /** @var string $level Nivel do log */
    private static $level;

    /**
     * Set Critical log
     * @param string|int $identifier
     * @param string $log_name
     * @param array $messages
     * @return mixed
     */
    public static function setCritical($identifier, $log_name, array $messages)
    {
        return static::setLog($identifier, $log_name, self::LOG_CRITICAL, $messages);
    }

    /**
     * Set Warning log
     * @param string|int $identifier
     * @param string $log_name
     * @param array $messages
     * @return mixed
     */
    public static function setWarning($identifier, $log_name, array $messages)
    {
        return static::setLog($identifier, $log_name, self::LOG_WARNING, $messages);
    }

    /**
     * Set Info log
     * @param string|int $identifier
     * @param string $log_name
     * @param array $messages
     * @return mixed
     */
    public static function setInfo($identifier, $log_name, array $messages)
    {
        return static::setLog($identifier, $log_name, self::LOG_INFO, $messages);
    }

    /**
     * Send request with log data via POST to External API
     * @param string $identifier identifier to easily found log
     * @param string $log_name
     * @param string $level
     * @param array $messages message to explain better what happend there
     * @return int http response code
     */
    private static function setLog($identifier, $log_name, $level, array $messages)
    {
        self::prepareLogIdentifier($identifier);
        self::prepareLogContent($messages);

        self::$log_name = $log_name;
        self::$level = $level;

        self::sendRequest(self::createPackage(true));
    }

    /**
     * Envia requisição para a serviço de logs via CURL
     * @param string $container json com logs a serem enviados
     */
    private static function sendRequest($container)
    {
        $exec = 'curl -H "Content-Type: application/json" -H "auth: '.self::API_AUTH.'" -H "Accept: application/json" ';
        $exec .= self::API_URI . ' -X POST -d \''.$container.'\' &> /dev/null &';
        //sleep(1);
        //dispatch(new SendLogToWarehouse($exec));

        //shell_exec($exec);
    }

    /**
     * Cria pacote com todas informações referente ao log
     * @param bool $to_json true caso deseje retorno em formato json ou false caso deseje retorno em array
     * @return array|string retorna array ou json
     */
    private static function createPackage($to_json = false)
    {
        $package = [
            'site' => 'eita',
            'identifier' => self::$identifier,
            'log_name' => self::$log_name,
            'level' => self::$level,
            'messages' => self::$content
        ];

        if ($to_json) {
            return self::encodePackage($package);
        }

        return $package;
    }

    /**
     * Encoda um array para json, utilizando uft8encode() se necessario
     * @param array $package
     * @return string json do $package enviado
     */
    public static function encodePackage($package)
    {
        $encoded_package = json_encode($package);

        if ($encoded_package == false) {
            $package['messages'] = utf8encode($package['messages'], true);
            $encoded_package = json_encode($package);
        }

        return $encoded_package;
    }

    /**
     * Prepara o conteudo do log para armazenamento
     * @param array $content conteudo do log
     */
    private static function prepareLogContent(array $content)
    {
        self::$content = $content;
    }

    /**
     * Valida se identificador foi informado, caso contrario, determina 'empty' como padrao
     * @param string|int $identifier identificador
     */
    private static function prepareLogIdentifier($identifier)
    {
        self::$identifier = ($identifier == false) ? 'empty' : addslashes($identifier);
    }
}
