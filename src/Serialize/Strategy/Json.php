<?php

namespace DevTools\Helpers\Serialize\Strategy;

use DevTools\Helpers\Exceptions\InvalidArgumentException;

class Json implements \DevTools\Helpers\Serialize\Serialize
{
    /**
     * List of JSON Error messages assigned to constant names for better handling of version differences.
     * @var array
     * @since 2.0.7
     */
    public static $jsonErrorMessages = [
        'JSON_ERROR_DEPTH' => 'The maximum stack depth has been exceeded.',
        'JSON_ERROR_STATE_MISMATCH' => 'Invalid or malformed JSON.',
        'JSON_ERROR_CTRL_CHAR' => 'Control character error, possibly incorrectly encoded.',
        'JSON_ERROR_SYNTAX' => 'Syntax error.',
        'JSON_ERROR_UTF8' => 'Malformed UTF-8 characters, possibly incorrectly encoded.', // PHP 5.3.3
        'JSON_ERROR_RECURSION' => 'One or more recursive references in the value to be encoded.', // PHP 5.5.0
        'JSON_ERROR_INF_OR_NAN' => 'One or more NAN or INF values in the value to be encoded', // PHP 5.5.0
        'JSON_ERROR_UNSUPPORTED_TYPE' => 'A value of a type that cannot be encoded was given', // PHP 5.5.0
    ];

    protected static function handleJsonError($lastError)
    {
        if ($lastError === JSON_ERROR_NONE) {
            return;
        }

        $availableErrors = [];
        foreach (static::$jsonErrorMessages as $const => $message) {
            if (defined($const)) {
                $availableErrors[constant($const)] = $message;
            }
        }

        if (isset($availableErrors[$lastError])) {
            throw new InvalidArgumentException($availableErrors[$lastError], $lastError);
        }

        throw new InvalidArgumentException('Unknown JSON encoding/decoding error.');
    }


    public function decode($content)
    {
        if (is_array($content)) {
            throw new InvalidArgumentException('Invalid JSON data.');
        } elseif ($content === null || $content === '') {
            return null;
        }
        $decode = json_decode((string)$content, true);
        static::handleJsonError(json_last_error());
        return $decode;
    }

    public function encode($param)
    {
        set_error_handler(function () {
            static::handleJsonError(JSON_ERROR_SYNTAX);
        }, E_WARNING);
        $json = json_encode($param, JSON_UNESCAPED_UNICODE);
        restore_error_handler();
        static::handleJsonError(json_last_error());

        return $json;
    }
}