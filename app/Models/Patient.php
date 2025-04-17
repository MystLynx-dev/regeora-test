<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Patient
 *
 * @property int                     $id
 * @property string                  $first_name
 * @property string                  $last_name
 * @property Carbon                  $birthdate
 * @property int|null                $age
 * @property string|null             $age_type
 *
 * @package App\Models\Patient
 */
class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'birthdate',
        'age',
        'age_type',
    ];

    protected $casts = [
        'birthdate' => 'datetime',
    ];
}
