<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\OrganisationCreated;
use App\Organisation;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class OrganisationService
 * @package App\Services
 */
class OrganisationService
{
    /**
     * Get filtered organisations list
     * @param Request $request
     * @param array $with
     * @return array
     */
    public function getFilteredOrganisations(Request $request, array $with = [])
    {
        return Organisation::query()
            ->with(array_intersect($with, ['owner']))
            ->when($request->filled('filter'), function ($query) use ($request) {
                return $query->filtered($request->filter);
            })
            ->get();
    }

    /**
     * Create new organization
     *
     * @param User $user
     * @param array $attributes
     *
     * @return Organisation
     */
    public function createOrganisation($user, array $attributes): Organisation
    {
        $organisation = new Organisation();
        $organisation->name = $attributes['name'];
        $organisation->owner_user_id = $user->id;
        $organisation->trial_end = Carbon::now()
            ->addDays(Organisation::TRIAL_PERIOD_DURATION_DAYS);
        $organisation->save();

        OrganisationCreated::dispatch($user, $organisation);

        return $organisation;
    }
}
