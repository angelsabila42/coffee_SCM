<?php
namespace App\Filter\V1;
use Illuminate\Http\Request;
use App\Filter\ApiFilter;

class VendorFilter extends ApiFilter
{
    protected $safeParms = [
        'name' => ['eq','like'],
        'email' => ['eq'],
        'city' => ['eq','like'],
        'street' => ['eq','like'],
        'phoneNumber' => ['eq']

    ];

    protected $columnMap = [
        'phoneNumber' => 'phone-number'
    ];
     protected $operatorMap = [
        'eq' => '=',
        'gt' => '>',
        'lt' => '<',
        'like' => 'like'
     ];

}