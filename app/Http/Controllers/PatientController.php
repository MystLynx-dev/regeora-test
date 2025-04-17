<?php

namespace App\Http\Controllers;

use App\Http\Resources\Patient\PatientCollection;
use App\Http\Resources\Patient\PatientResource;
use App\Jobs\PatientJob;
use App\Models\Patient;
use App\Services\Patient\PatientService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Exception;
use Psr\SimpleCache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class PatientController extends Controller
{
    public function __construct(
        private readonly PatientService $patientService,
    ) {

    }

    /**
     * @throws InvalidArgumentException
     */
    public function view(): Response
    {
        return response()->json(new PatientCollection(Patient::all()));
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): Response
    {
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthdate' => 'required|string|max:255',
        ]);

        try {
            $patient = $this->patientService->createPatient($request);
        } catch (Throwable $e) {
            throw new Exception('Ошибка: ' . $e->getMessage());
        }

        PatientJob::dispatch($patient)->onQueue('default');

        return Cache::remember('create_patient_' . $patient->id, 300, static function() use ($patient) {
            return response()->json(new PatientResource($patient));
        });
    }
}
