<?php
namespace Services\V1;
use Illuminate\Http\Request;

class VendorQuery
{
    protected $safeParms = [
        'name' => ['eq'],
        'email' => ['eq'],
        'city' => ['eq'],
        'street' => ['eq'],
        'phoneNumber' => ['eq']

    ];

    protected $columnMap = [
        'phoneNumber' => 'phone-number'
    ];
     protected $operatorMap = [
        'eq' => '='
     ];

    public function Transform(Request $request){
        $query = [];

        foreach($this->safeParms as $parm => $operators){
            $query = $request->query($parm);

            if (!isset($query)){
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;

            foreach($operators as $operator){
                if(isset($query[$operator])){
                    $query = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }

        return $query;

    }
}