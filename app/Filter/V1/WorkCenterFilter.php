<?php
namespace App\Filter\V1;
use Illuminate\Http\Request;
use App\Filter\ApiFilter;

class WorkCenterFilter extends ApiFilter
{
    protected $safeParms = [
        'centerName' => ['eq','like'],
        'workCenterID' => ['eq','like'],
        'location' => ['eq', 'like']
    ];

     protected $operatorMap = [
        'eq' => '=',
        'gt' => '>',
        'lt' => '<',
        'like' => 'like',
        'ne' => '!=',
        'gte' => '>=',
        'lte' => '<='
     ];

}

    