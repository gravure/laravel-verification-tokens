<?php

namespace Gravure\Verification;

use Carbon\Carbon;
use Gravure\Verification\Contracts\Generator;
use Gravure\Verification\Generators\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Token
 * @package Gravure\Verification
 * @property int $id
 * @property string $token
 * @property int $created_by
 * @property int $created_for
 * @property string $callback
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $expires_at
 * @property Carbon $send_at
 */
class Token extends Model
{
    /**
     * @var string
     */
    protected $table = 'verification_tokens';

    /**
     * @var array
     */
    protected $dates = ['expires_at', 'send_at'];

    /**
     * @var Generator
     */
    protected static $generator;

    /**
     * @param string $value
     * @return string
     */
    public function setCallbackAttribute(string $value)
    {
        if (!empty($value) && strstr($value, '@')) {
            list($class, $method) = explode('@', $value);

            if (class_exists($class) && method_exists($class, $method)) {
                return $this->attributes['callback'] = $value;
            }
        }

        throw new \InvalidArgumentException("Callback has to of format <class>@<method>");
    }

    /**
     * Generates a random string if not set.
     *
     * @param string $value
     * @return string
     */
    public function getTokenAttribute(string $value)
    {
        if ($value === null) {
            $value = static::$generator->generate();
        }

        return $value;
    }

    /**
     * @return mixed
     */
    public function getCallback()
    {
        list($class, $method) = explode('@', $this->callback);

        return call_user_func([
            app()->make($class), $method
        ], $this);
    }

    /**
     * Override the key, allowing model binding in routes.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'token';
    }

    /**
     * @param Generator $generator
     */
    public static function setGenerator(Generator $generator)
    {
        static::$generator = $generator;
    }

    /**
     * @return Generator
     */
    public static function getGenerator(): Generator
    {
        if (! static::$generator) {
            static::$generator = new UuidGenerator;
        }

        return static::$generator;
    }
}
