<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\VendorResource;
use App\Http\Resources\V1\VendorCollection;
use App\Filter\V1\VendorFilter;
use App\Http\Requests\V1\StoreVendorRequest;
use App\Http\Requests\V1\UpdateVendorRequest;
use App\Http\Resources\V1\VendorDropDownResource;
use App\Models\User;
use App\Models\Vendor;
use App\Models\QA;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class VendorController extends Controller
{
       
//   'name',
//         'email',
//        'email',
//         'phone_number',
//         'street',
//         'city',

    public function index(Request $request){

        $filter = new VendorFilter();
        $filterItems = $filter->Transform($request);

        $vendors = Vendor::where($filterItems)->paginate();

         return new VendorCollection($vendors->appends($request->query()));
    }

    public function show(Vendor $vendor){
        return new VendorResource($vendor);
    }


    /*public function store(StoreVendorRequest $request){
      return new VendorResource(Vendor::create($request->all()));

    }*/

    public function Transactions() {
    return view('transactions.vendor-dashboard');
}

    public function update(UpdateVendorRequest $request, Vendor $vendor){
      $vendor->update($request->all());
    }

    public function dropdown(){
      return VendorDropDownResource::collection(Vendor::select('id', 'name')->get());
    }



 public function vendor(){
        return view('auth.vendor');
    }




   public function pdfValidation(Request $request){


      $validated = $request->validate([
              'name' => 'required',
            'email' => 'required|email|unique:vendor,email',
           // 'password' => ['required','confirmed','min:8'],
            'street' => '',
              'city' => '',
            'phone_number' => 'required|regex:/^07[0-9]{8}$/',
            // 'document' => 'required|file|mimes:pdf',
            'Bank_account' => 'required|max:2048',
         'Account_holder'=> 'required|max:2048',
         'Bank_name' => 'required|max:2048',
        
        ]);

     if ($request->hasFile('financial_statement') && $request->hasFile('national_id') && $request->hasFile('UCDA')) {
    $financialStatement = $request->file('financial_statement');
    $nationalId = $request->file('national_id');
    $ucda = $request->file('UCDA');

    $financialStatementBase64 = base64_encode(file_get_contents($financialStatement->getRealPath()));
    $nationalIdBase64 = base64_encode(file_get_contents($nationalId->getRealPath()));
    $ucdaBase64 = base64_encode(file_get_contents($ucda->getRealPath()));
     } else {
        return redirect()->back()->with('message' , 'Please upload all required documents');
    }

// $nationalId = $request->file('national_id');
// $nationalIdBase64 = base64_encode(file_get_contents($nationalId->getRealPath()));
    
//     // java_data_validation
    $java_data_validation = [
        'userName' => $request->input('name'),
        'id' => $nationalIdBase64,
         'idName' => $nationalId->getClientOriginalName(),
        'financialStatus' => $financialStatementBase64,
        'financialStatusName' => $financialStatement->getClientOriginalName(),
       'ucdaCertificate' => $ucdaBase64,
       'ucdaCertificateName' => $ucda->getClientOriginalName(),
    ];
     $res = Http::post('http://localhost:8081/api/verify', $java_data_validation);

      

        if ($res->successful()) {

          if ($res->body() == 'Validation successful.') {

      
      
          $this->store($request);
          
          //return $res->body();
          return redirect()->back()->with('success','vendor registered successfully');

                } else {
       // return $res->body();
           return  redirect()->back()->with('error','registration failed, please upload valid documents');}
      
      # code...
      
    }

      else {
            return response()->json(['message' => $res->body()], 500);  
        }

      }



          public function store(Request $req){


          $validated = $req->validate([
              'name' => 'required',
            'email' => 'required|email|unique:vendor,email',
           // 'password' => ['required','confirmed','min:8'],
            'street' => '',
              'city' => '',
            'phone_number' => 'required|regex:/^07[0-9]{8}$/',
            // 'document' => 'required|file|mimes:pdf',
            'Bank_account' => 'required',
         'Account_holder'=> 'required',
         'Bank_name' => 'required',
        

        ]);   
       // $validated['password'] = Hash::make($validated['password']);
         // $filepath = $req->file('financial_statement')->store('vendor_files','public');
        


        vendor::create($validated);
/*$fields = collect($validated)->only([
              'name','email','password'
              ])->toArray();

          User::create($fields);*/
        return redirect()->route('vendor.home')->with('success', 'Vendor registered successfully');
       // return response()->json(['message' => 'Vendor registered successfully']);

        }
        public function venReport(){
                    
          $user = Auth::user();
          $vendor = Vendor::where('email', $user->email)->first();

          if($vendor){
              $reports = QA::where('vendor_id', $vendor->id)->paginate(10);
          } else {
              $reports = collect(); // Empty collection if no vendor found
          }

        return view('qa.vendor-report',compact('reports'));
   }

   public function venReportDetails($reportID){
                
          $user = Auth::user();
          $vendor = Vendor::where('email', $user->email)->first();

       $report = QA::where('reportID', $reportID)->firstOrFail();
       if($report)
      return view('qa.vendor-report-details', compact('report'));
  }
   }


// end of vendorController.php   
    
    
    
  
