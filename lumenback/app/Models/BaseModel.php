<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * App\Models\BaseModel
 *
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self filter(array $data)
 */
abstract class BaseModel extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [

    ];

    public $translatable = [];

    /*
     public function scopeFilter($query, $data)
     {
         if (isset($data['status']))
         {
             $query->whereHas('roles', function ($q) use ($data) {
                 $q->where('status', $data['status']);
             });
         }

         if (isset($data['role']))
         {
             $query->whereHas('roles', function ($q) use ($data) {
                 $q->where('role_code', $data['role']);
             });
         }
         return $query;
     }
         */
}
