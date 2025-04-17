<?php

namespace app\Http\Resources\Patient;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray(Request $request): array|JsonSerializable|Arrayable
    {
        return [
            'name' => $this->first_name . ' ' . $this->last_name,
            'birthdate' => $this->birthdate->format('d.m.Y'),
            'age' => $this->age . ' ' . $this->age_type,
        ];
    }
}
