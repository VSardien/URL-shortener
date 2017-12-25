<?php
namespace Classes;

use J0sh0nat0r\SimpleCache\StaticFacade as Cache;

class Model implements \JsonSerializable
{
    public static $table = null;
    public static $primary_key = null;

    protected $attributes;

    public function __construct($attributes)
    {
        $this->attributes = $attributes;
    }

    public function __get($name)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        if (method_exists($this, 'get' . ucfirst($name))) {
            return $this->{'get' . ucfirst($name)}();
        }
    }

    public function update($new_attributes) {
        global $db;

        $this->attributes = array_merge($this->attributes, $new_attributes);

        $to_update = $this->attributes;
        unset($to_update[static::$primary_key]);

        $db->update(static::$table, $to_update, static::$primary_key . ' = ?', [$this->attributes[self::$primary_key]]);

        Cache::store('db-'.strtolower(get_called_class()).'s-'.$this->attributes[static::$primary_key], $this, 3600);
    }

    public static function find($key)
    {
        $model = static::class;

        return Cache::remember('db-'.strtolower(get_called_class()).'s-'.$key, 3600, function() use($key, $model) {
            global $db;

            $results = $db->select ( '*', $model::$table, static::$primary_key . ' = ?', [$key])->fetch_assoc();
            if($results === null) {
                return null;
            }

            return new $model($results);
        });
    }
    public static function create($attributes)
    {
        global $db;

        $db->insert(static::$table, $attributes);

        return new static($attributes);
    }
    public static function fetchAll()
    {
        $model = static::class;

        return Cache::remember('db-'.strtolower(get_called_class()).'s', 3600, function() use($model) {
            global $db;

            $db->query('SELECT * FROM '. $model::$table);
            $results = $db->fetch_assoc_all();
            //$results = $db->select('*', $model::$table)->fetch_assoc_all();
            if($results === null) {
                return null;
            }
            $models = [];

            foreach($results as $attributes) {
                $models[] = new $model($attributes);
            }

            return $models;
        });
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return $this->attributes;
    }
}
