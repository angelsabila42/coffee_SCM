<aside id="sidebar" :class= "{'expand':isExpanded}">
    <div class="d-flex justify-content-between px-4 pt-4">
        <div class="sidebar-logo mr-1" >
            <p class=" fw-bold mb-0 sidebar-logo">GlobalBean Connect</p>
            <p class="text-muted small hide-on-collapse">Dashboard</p>
        </div>
    
    <button type="button" class="toggle-btn border-0"  x-on:click= "toggle">
        <i id="icon" :class = "isExpanded ? 'bx bxs-sidebar' : 'bx  bxs-sidebar-right'"> </i>
    </button>
    </div>
    <hr class="pb-2">

    {{-- <div class="d-flex justify-content-end align-items-center px-4 mb-0">
    
    <button type="button" class="toggle-btn border-0"  x-on:click= "toggle">
        <i id="icon" :class = "isExpanded ? 'fa-solid fa-chevron-left' : 'fa-solid fa-chevron-right'"> </i>
    </button>
    </div>
    

    <div class="sidebar-logo mr-1" ><div class="p-3 mb-0 hide-on-collapse ">
            {{-- <h4 class=" fw-bold mb-0 sidebar-logo">GlobalBean Connect</h4>
            <p class="text-muted small hide-on-collapse">Dashboard</p>
        </div>
    </div>  --}}
    

    @yield('sidebar-items')

</aside>
