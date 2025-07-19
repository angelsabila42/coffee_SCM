@extends('layouts.app')
@section('content')
@section('sidebar-items')
@include('layouts.sidebar-items.admin')
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-4">
            <h2 class="fw-bold">Quality Assessment</h2>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('qa.store') }}" method="POST" id="qaForm">
                        @csrf
                        <h3 class="mb-4">Green Coffee Inspection</h3>
                        <hr class="section-divider">

                        <div class="row mb-12">
                            <div class="col-md-6">
                                <div class="form-group">                                    <label for="date" class="fw-bold">Date:</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="testers_initials" class="fw-bold">Tester's Initials:</label>
                                    <input type="text" class="form-control" id="testers_initials" name="testers_initials" required>
                                </div>
                            </div>
                        </div>

                        <h4 class="mb-3">Green Coffee Inspection</h4>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">                                    <label for="region" class="fw-bold">Region:</label>
                                    <input type="text" class="form-control" id="region" name="region" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="vendor_id" class="fw-bold">Vendor:</label>
                                    <select class="form-control" id="vendor_id" name="vendor_id" required>
                                        <option value="">Select</option>
                                        @foreach($vendors ?? [] as $vendor)
                                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">                                    <label for="ref" class="fw-bold">Ref#:</label>
                                    <input type="text" class="form-control" id="ref" name="ref" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="crop_year" class="fw-bold">Crop Year:</label>
                                    <input type="text" class="form-control" id="crop_year" name="crop_year" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">                                    <label for="screen_description" class="fw-bold">Screen Description:</label>
                                    <input type="text" class="form-control" id="screen_description" name="screen_description">
                                </div>
                            </div>
                        </div>               
                           {{-- Color Selection --}}
<div class="form-section mb-4">
    <label class="form-label fw-bold">Color</label>   
       <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="bg-black">
                <tr>
                    <th class="text-white fw-bold">Blue-green</th>
                    <th class="text-white fw-bold">Bluish-green</th>
                    <th class="text-white fw-bold">Green</th>
                    <th class="text-white fw-bold">Greenish</th>
                    <th class="text-white fw-bold">Yellow green</th>
                    <th class="text-white fw-bold">Pale Yellow</th>
                    <th class="text-white fw-bold">Yellowish</th>
                    <th class="text-white fw-bold">Brownish</th>
                </tr>
            </thead><tbody>
                <tr>
                    <td class="px-3 py-2"><input type="radio" name="color" value="blue-green" class="form-check-input"></td>
                    <td class="px-3 py-2"><input type="radio" name="color" value="bluish-green" class="form-check-input"></td>
                    <td class="px-3 py-2"><input type="radio" name="color" value="green" class="form-check-input"></td>
                    <td class="px-3 py-2"><input type="radio" name="color" value="greenish" class="form-check-input"></td>
                    <td class="px-3 py-2"><input type="radio" name="color" value="yellow-green" class="form-check-input"></td>
                    <td class="px-3 py-2"><input type="radio" name="color" value="pale-yellow" class="form-check-input"></td>
                    <td class="px-3 py-2"><input type="radio" name="color" value="yellowish" class="form-check-input"></td>
                    <td class="px-3 py-2"><input type="radio" name="color" value="brownish" class="form-check-input"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Green Coffee Inspection --}}
<div class="form-section mb-4">
    <label class="form-label fw-bold">Green Coffee Inspection</label>
    <div class="row">
        {{-- Category 1 defects --}}
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-header bg-dark text-white">Category 1 defects</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Full black bean (1)
                            <input type="checkbox" name="defects[category1][full_black_bean]" value="1" class="form-check-input">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Fungus damaged bean (1)
                            <input type="checkbox" name="defects[category1][fungus_damaged_bean]" value="1" class="form-check-input">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Severe insect damaged bean (5)
                            <input type="checkbox" name="defects[category1][severe_insect_damaged_bean]" value="5" class="form-check-input">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Foreign matter (5)
                            <input type="checkbox" name="defects[category1][foreign_matter]" value="5" class="form-check-input">
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Category 2 defects (first column) --}}
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-header bg-dark text-white">Category 2 defects</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Partial Black bean (3)
                            <input type="checkbox" name="defects[category2][partial_black_bean]" value="3" class="form-check-input">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Floater bean (5)
                            <input type="checkbox" name="defects[category2][floater_bean]" value="5" class="form-check-input">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Broken/Chipped/cut (5)
                            <input type="checkbox" name="defects[category2][broken_chipped_cut]" value="5" class="form-check-input">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Immature/unripe bean (5)
                            <input type="checkbox" name="defects[category2][immature_unripe_bean]" value="5" class="form-check-input">
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Category 3 defects --}}
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-header bg-dark text-white">Category 3 defects</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Hull/husk (5)
                            <input type="checkbox" name="defects[category3][hull_husk]" value="5" class="form-check-input">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Withered bean (5)
                            <input type="checkbox" name="defects[category3][withered_bean]" value="5" class="form-check-input">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Slight insect damaged bean (10)
                            <input type="checkbox" name="defects[category3][slight_insect_damaged_bean]" value="10" class="form-check-input">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Shell (5)
                            <input type="checkbox" name="defects[category3][shell]" value="5" class="form-check-input">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
                      

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">                                    <label for="fragrance" class="fw-bold">Fragrance:</label>
                                    <input type="text" class="form-control" id="fragrance" name="fragrance" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="moisture_content" class="fw-bold">Moisture Content:</label>
                                    <input type="number" step="0.1" class="form-control" id="moisture_content" name="moisture_content" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="overall_impression" class="fw-bold">Overall Impression:</label>
                                    <input type="text" class="form-control" id="overall_impression" name="overall_impression" required>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" name="save_draft" value="1" class="btn btn-secondary">Save as Draft</button>
                            <a href="{{ route('qa.index') }}" class="btn btn-light">Back</a>
                            <button onclick="window.location='{{ route('qa.store', $record->id) }}'" type="submit" name="status" value="submitted" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    background: #fff;
    border: none;
}

.card-header {
    background-color: black !important;
    border-bottom: none;
    border-top-left-radius: 15px !important;
    border-top-right-radius: 15px !important;
    padding: 1.5rem;
}

.card-body {
    padding: 1.5rem;
    background: #fff;
}

.color-buttons {
    display: flex;
    gap: 0;
    width: 100%;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    overflow: hidden;
}

.color-option {
    flex: 1;
}

.color-option input[type="radio"] {
    display: none;
}

.color-btn {
    display: block;
    width: 100%;
    padding: 8px 4px;
    text-align: center;
    background: #343a40;
    color: white;
    cursor: pointer;
    margin: 0;
    font-size: 0.9rem;
    border-right: 1px solid #454d55;
}

.color-option:last-child .color-btn {
    border-right: none;
}

.color-option input[type="radio"]:checked + .color-btn {
    background: #454d55;
}

.section-divider {
    margin: 1rem 0 2rem;
    border: 0;
    border-top: 1px solid #dee2e6;
    opacity: 0.8;
}

h2.fw-bold {
    font-size: 1.75rem;
    margin-bottom: 1rem;
}

.category-box {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-bottom: 1rem;
    background: #fff;
}

.category-header {
    display: flex;
    justify-content: space-between;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    padding: 0.5rem 1rem;
    background: #343a40;
}

.category-items {
    background-color: #fff;
    padding: 1rem;
}

.btn-check:checked + .btn-outline-secondary {
    background-color: #6c757d;
    color: white;
}

.card-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 0;
}

.form-control {
    border-radius: 6px;
    border: 1px solid #ced4da;
    padding: 0.5rem 0.75rem;
}

.btn {
    border-radius: 6px;
    padding: 0.5rem 1rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    margin-bottom: 0.5rem;
    font-weight: 700;
}
label {
    font-weight: 700 !important;
}
.bg-black {
    background-color: black !important;
    color: white !important;
}

.table th {
    font-weight: 700 !important;
    vertical-align: middle !important;
}

.table td {
    vertical-align: middle !important;
}

.form-check-input[type="radio"] {
    margin: 0 auto;
  
}
</style>
@endsection

