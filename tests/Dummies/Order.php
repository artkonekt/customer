<?php

declare(strict_types=1);

namespace Konekt\Customer\Tests\Dummies;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
