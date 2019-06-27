<?php
namespace Msi\Falcon\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function __construct(array $attributes = [])
    {
        $this->connection = env('DB_FALCON_CONNECTION', 'mysql');
        
        parent::__construct($attributes);
    }

    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
        
    }

    public function getRememberTokenName()
    {
        return null;
    }

    /**
     * Overrides the method to ignore the remember token.
     */
    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (! $isRememberTokenAttribute) {
            parent::setAttribute($key, $value);
        }
    }
}
