<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Organisation;
use League\Fractal\TransformerAbstract;

/**
 * Class OrganisationTransformer
 * @package App\Transformers
 */
class OrganisationTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'owner'
    ];

    /**
     * @param Organisation $organisation
     *
     * @return array
     */
    public function transform(Organisation $organisation): array
    {
        return [
            'id' => $organisation->id,
            'name' => $organisation->name,
            'trial_end' => $organisation->trial_end->toDateTimeString(),
            'subscribed' => $organisation->subscribed,
            'created_at' => $organisation->created_at->toDateTimeString()
        ];
    }

    /**
     * @param Organisation $organisation
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeOwner(Organisation $organisation)
    {
        return $this->item($organisation->owner, new UserTransformer());
    }
}
