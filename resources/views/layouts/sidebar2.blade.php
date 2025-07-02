<aside id="sidebar" :class= "{'expand':isExpanded}">
    <div class="d-flex justify-content-between p-4">
        <div class="sidebar-logo mr-1" >
            <a href="#">GlobalBean Connect</a>
        </div>
    
    <button type="button" class="toggle-btn border-0"  x-on:click= "toggle">
        <i id="icon" :class = "isExpanded ? 'bx bxs-chevrons-left' : 'bx bxs-chevrons-right'"> </i>
    </button>
    </div>
    @yield('sidebar-item')
</aside>
