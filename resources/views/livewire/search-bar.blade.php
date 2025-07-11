{{-- <div>
    {{-- Because she competes with no one, no one can compete with her. 
</div> --}}
<div id="search-bar" class="position-relative">
    <form class="d-flex" role="search">
        <input 
            wire:model.live="search" 
            class="form-control me-2" 
            type="search" 
            placeholder="Search" 
            aria-label="Search">
    </form>

    @if(strlen($search) > 1 && count($users) > 0)
        <div class="dropdown-menu d-block w-100 shadow mt-1">
            @foreach($users as $user)
                <div class="px-3 py-2 border-bottom">
                    <div class="d-flex flex-column">
                        <strong>{{ $user->name }}</strong>
                        <small class="text-muted">{{ $user->email }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
