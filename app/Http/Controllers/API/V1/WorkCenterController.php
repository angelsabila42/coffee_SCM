<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\WorkCenterCollection;
use App\Http\Resources\V1\WorkCenterResource;
use App\Http\Resources\V1\WorkCenterDropDownResource;
use App\Models\WorkCenter;
use Illuminate\Http\Request;
use App\Filter\V1\WorkCenterFilter;

class WorkCenterController extends Controller
{
        public function index(Request $request){

        $filter = new WorkCenterFilter();
        $filterItems = $filter->Transform($request);

        $centers = WorkCenter::where($filterItems)->paginate;

        return new WorkCenterCollection($centers->appends($request->query()));
    }

    public function dropdown(){
      return WorkCenterDropDownResource::collection(WorkCenter::select('id', 'centerName')->get());
    }


    public function show(WorkCenter $workCenter){
        return new WorkCenterResource($workCenter);
    }
   
}
