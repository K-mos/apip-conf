<?php

declare(strict_types=1);

namespace App\Annotation;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::IS_REPEATABLE)]
class FilterPermission
{
    private const CURRENT_USER_VALUES = [
        'organization' => 'user.getOrganization()',
        'service' => 'user.getService()',
        'position' => 'user.getPosition()',
        'manager' => 'user.getId()',
    ];

    public string $name;
    public string $field;
    public string $value;

    public function __construct(string $name, ?string $field = null, ?string $value = null)
    {
        $this->name = $name;
        $this->field = $field ?: $name;
        $this->value = $value ?: self::CURRENT_USER_VALUES[$name] ?: '';
    }
}
