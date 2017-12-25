<?php
namespace Models;

use Classes\Model;

class User extends Model {
    public static $table = 'users';
    public static $primary_key = 'id';

    protected function getAvatarUrl() {
        if(!empty($this->attributes['avatar'])) {
            return "https://cdn.discordapp.com/avatars/{$this->id}/{$this->avatar}.png";
        }
        return 'https://discordapp.com/assets/1cbd08c76f8af6dddce02c5138971129.png';
    }
}