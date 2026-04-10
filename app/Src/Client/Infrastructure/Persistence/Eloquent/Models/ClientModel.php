<?php

namespace App\Src\Client\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent model for the clients table.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class ClientModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'clients';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];
}