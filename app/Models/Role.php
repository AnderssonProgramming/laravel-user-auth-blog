<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the users for the role.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Role constants.
     */
    const ADMIN = 'admin';
    const EDITOR = 'editor';
    const USER = 'user';

    /**
     * Get all available roles.
     */
    public static function availableRoles(): array
    {
        return [
            self::ADMIN => 'Administrator - Full system access',
            self::EDITOR => 'Editor - Can create and manage all posts',
            self::USER => 'User - Can create and manage own posts',
        ];
    }
}
