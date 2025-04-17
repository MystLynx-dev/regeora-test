<?php

namespace App\Services\Patient;

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;


/**
 * Class PatientService
 *
 * @package App\Services\Patient
 */
class PatientService
{
    public function __construct()
    {
    }

    /**
     * @param Request $request
     *
     * @return Patient
     */
    public function createPatient(Request $request): Patient
    {
        $birthdate = Carbon::parse($request->input('birthdate'));
        $now = Carbon::createFromDate();

        if ($birthdate->diffInYears($now)) {
            $age = $birthdate->diffInYears($now);
            $age_type = 'год';
        } elseif ($birthdate->diffInMonths($now)) {
            $age = $birthdate->diffInMonths($now);
            $age_type = 'месяц';
        } elseif ($birthdate->diffInDays($now)) {
            $age = $birthdate->diffInDays($now);
            $age_type = 'день';
        } else {
            $age = null;
            $age_type = '';
        }

        return Patient::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'birthdate' => $request->input('birthdate'),
            'age' => $age,
            'age_type' => $age_type,
        ]);
    }
}
