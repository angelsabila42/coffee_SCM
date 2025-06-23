<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\WorkCenterCollection;
use App\Http\Resources\V1\WorkCenterResource;
use App\Models\WorkCenter;
use Illuminate\Http\Request;

class WorkCenterController extends Controller
{
    public function index(){
        return new WorkCenterCollection(WorkCenter::paginate());
    }

      public function show(WorkCenter $vendor){
        return new WorkCenterResource($vendor);
    }
}
