<!--   Core JS Files   -->
{{-- <script src="{{asset('assets/js/core/jquery.3.2.1.min.js')}}" type="text/javascript"></script> --}}
<script src="{{asset('assets/js/core/popper.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/core/bootstrap.min.js')}}" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="{{asset('assets/js/plugins/bootstrap-switch.js')}}"></script>
<!--  Chartist Plugin  -->
<script src="{{asset('assets/js/plugins/chartist.min.js')}}"></script>
<!--Apex Charts plugin-->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!--  Notifications Plugin    -->
<script src="{{asset('assets/js/plugins/bootstrap-notify.js')}}"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<!--script src="{{--asset('assets/js/light-bootstrap-dashboard.js?v=2.0.0 ')--}}" type="text/javascript"></script-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="{{asset('assets/js/demo.js')}}"></script>


<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>


<!--script type="text/javascript">
    $(document).ready(function() {
        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

       // demo.showNotification();

    });

</script-->

<script src= "{{asset('/assets/js/custom.js')}}"></script>     





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
 
<script>
// Session keep-alive ping to prevent session expiry during chat
setInterval(function() {
    fetch('/keep-alive', { method: 'GET', credentials: 'same-origin' });
}, 5 * 60 * 1000); // every 5 minutes
</script>
@livewireScripts  



