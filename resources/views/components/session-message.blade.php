<div>
    @if(session('success'))
        <div id="flash" class= "p-4 text-center alert alert-success font-weight-bold " >
            {{session('success')}}
        </div>
    @endif
</div>