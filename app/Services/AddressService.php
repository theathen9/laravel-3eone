<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use RuntimeException;

class AddressService
{
    protected array $data;

    public function __construct()
    {
        $path = storage_path('app/data/addressCambodia.json');

        if (!File::exists($path)) {
            throw new RuntimeException(
                'Cambodia address data file not found.'
            );
        }

        $this->data = json_decode(
            File::get($path),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    /**
     * Get provinces
     */
    public function getProvinces(): array
    {
        return array_keys($this->data);
    }

    /**
     * Get districts
     */
    public function getDistricts(string $province): ?array
    {
        if (!isset($this->data[$province])) {
            return null;
        }

        return array_keys(
            $this->data[$province]['districts'] ?? []
        );
    }

    /**
     * Get communes
     */
    public function getCommunes(
        string $province,
        string $district
    ): ?array {

        if (!isset($this->data[$province])) {
            return null;
        }

        $districts = $this->data[$province]['districts'] ?? [];

        if (!isset($districts[$district])) {
            return null;
        }

        return array_keys(
            $districts[$district]['communes'] ?? []
        );
    }

    /**
     * Get villages
     */
    public function getVillages(
        string $province,
        string $district,
        string $commune
    ): ?array {

        if (!isset($this->data[$province])) {
            return null;
        }

        $districts = $this->data[$province]['districts'] ?? [];

        if (!isset($districts[$district])) {
            return null;
        }

        $communes = $districts[$district]['communes'] ?? [];

        if (!isset($communes[$commune])) {
            return null;
        }

        $villages = $communes[$commune]['villages'] ?? [];

        if (!is_array($villages)) {
            return [];
        }

        /*
        |--------------------------------------------------------------------------
        | Handle both list and associative array
        |--------------------------------------------------------------------------
        */

        if (!array_is_list($villages)) {
            $villages = array_keys($villages);
        }

        /*
        |--------------------------------------------------------------------------
        | Clean village names
        |--------------------------------------------------------------------------
        */

        $villages = array_map(
            fn($village) => trim((string) $village),
            $villages
        );

        return array_values(
            array_unique(
                array_filter($villages)
            )
        );
    }

    /**
     * Check province
     */
    public function provinceExists(string $province): bool
    {
        return isset($this->data[$province]);
    }

    /**
     * Check district
     */
    public function districtExists(
        string $province,
        string $district
    ): bool {
        return isset(
            $this->data[$province]['districts'][$district]
        );
    }

    /**
     * Check commune
     */
    public function communeExists(
        string $province,
        string $district,
        string $commune
    ): bool {
        return isset(
            $this->data[$province]['districts'][$district]['communes'][$commune]
        );
    }
}
