<?php

declare(strict_types=1);

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Organisation\RequestIndex;
use App\Http\Requests\Organisation\RequestStore;
use App\Organisation;
use App\Services\OrganisationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class OrganisationController
 * @package App\Http\Controllers
 */
class OrganisationController extends ApiController
{
    /**
     * Store new organization
     *
     * @param RequestStore $requestStore
     * @param OrganisationService $service
     *
     * @return JsonResponse
     */
    public function store(RequestStore $requestStore, OrganisationService $service): JsonResponse
    {
        /** @var Organisation $organisation */
        $organisation = $service->createOrganisation(
            Auth::user(),
            $requestStore->validated()
        );

        return $this
            ->transformItem('organisation', $organisation, ['owner'])
            ->respond();
    }

    /**
     * Get organization list
     *
     * @param RequestIndex $requestIndex
     * @param OrganisationService $service
     * @return JsonResponse
     */
    public function index(RequestIndex $requestIndex, OrganisationService $service)
    {
        return $this->transformCollection(
            'organisations',
            $service->getFilteredOrganisations($requestIndex, ['owner']),
            ['owner']
        )->respond();
    }
}
