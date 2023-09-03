 <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="{{asset ('assets/js/lib/jquery-3.4.1.min.js')}}"></script>
    <!-- Bootstrap-->
    <script src="{{asset ('assets/js/lib/popper.min.js')}}"></script>
    <script src="{{asset ('assets/js/lib/bootstrap.min.js')}}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="{{asset ('assets/js/plugins/owl-carousel/owl.carousel.min.js')}}"></script>
    <!-- jQuery Circle Progress -->
    <script src="{{asset ('assets/js/plugins/jquery-circle-progress/circle-progress.min.js')}}"></script>
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOgmBMhKUtn9GKnZ6MjYad9-1VrnHjGms"></script>
    <!-- Base Js File -->
    <script src="{{asset ('assets/js/base.js?v='.time())}}"></script>
    <script src="{{asset ('assets/js/custom.js?v='.time())}}"></script>
    <script> const baseUrl = "{{ url('/') }}"; </script>
    <script src="{{asset ('assets/js/register.js?v='.time())}}"></script>

@stack('myscript')