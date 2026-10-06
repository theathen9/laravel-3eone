<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\AddressService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(
        protected AddressService $addressService
    ) {}

    /**
     * GET /api/v1/address
     *
     * Supported types:
     *
     * provinces
     * districts
     * communes
     * villages
     */
    public function index(Request $request): JsonResponse
    {
        $type = $request->query('type');

        switch ($type) {

            /*
            |--------------------------------------------------------------------------
            | Provinces
            |--------------------------------------------------------------------------
            */

            case 'provinces':

                return response()->json(
                    $this->addressService->getProvinces()
                );


                /*
            |--------------------------------------------------------------------------
            | Districts
            |--------------------------------------------------------------------------
            */

            case 'districts':

                $request->validate([
                    'province' => ['required', 'string'],
                ]);

                $province = $request->query('province');

                $districts = $this->addressService->getDistricts(
                    $province
                );

                if ($districts === null) {
                    return response()->json([
                        'message' => 'Province not found.',
                    ], 404);
                }

                return response()->json($districts);


                /*
            |--------------------------------------------------------------------------
            | Communes
            |--------------------------------------------------------------------------
            */

            case 'communes':

                $request->validate([
                    'province' => ['required', 'string'],
                    'district' => ['required', 'string'],
                ]);

                $province = $request->query('province');
                $district = $request->query('district');

                $communes = $this->addressService->getCommunes(
                    $province,
                    $district
                );

                if ($communes === null) {

                    if (!$this->addressService->provinceExists($province)) {
                        return response()->json([
                            'message' => 'Province not found.',
                        ], 404);
                    }

                    return response()->json([
                        'message' => 'District not found.',
                    ], 404);
                }

                return response()->json($communes);


                /*
            |--------------------------------------------------------------------------
            | Villages
            |--------------------------------------------------------------------------
            */

            case 'villages':

                $request->validate([
                    'province' => ['required', 'string'],
                    'district' => ['required', 'string'],
                    'commune' => ['required', 'string'],
                ]);

                $province = $request->query('province');
                $district = $request->query('district');
                $commune = $request->query('commune');

                $villages = $this->addressService->getVillages(
                    $province,
                    $district,
                    $commune
                );

                if ($villages === null) {

                    if (!$this->addressService->provinceExists($province)) {
                        return response()->json([
                            'message' => 'Province not found.',
                        ], 404);
                    }

                    if (!$this->addressService->districtExists(
                        $province,
                        $district
                    )) {
                        return response()->json([
                            'message' => 'District not found.',
                        ], 404);
                    }

                    return response()->json([
                        'message' => 'Commune not found.',
                    ], 404);
                }

                return response()->json($villages);


                /*
            |--------------------------------------------------------------------------
            | Invalid type
            |--------------------------------------------------------------------------
            */

            default:

                return response()->json([
                    'message' => 'Invalid address type.',
                    'allowed' => [
                        'provinces',
                        'districts',
                        'communes',
                        'villages',
                    ],
                ], 400);
        }
    }
}
