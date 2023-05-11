

    <div class="resize_contaiiner">
        <div class="resize_row">
            <i class="fa-solid fa-desktop" onclick="DesktopView()"></i>
            <i class="fa-solid fa-mobile-screen" onclick="PhoneView()"></i>
        </div>
    </div>


@section('javascript')
    <script>
        function DesktopView() {
            var myDiv = document.getElementById("myDiv");

            // Get the size
            var width = myDiv.offsetWidth;
            var height = myDiv.offsetHeight;

            alert("Width: " + width + ", Height: " + height);
        }

        function PhoneView() {

            // Get body element
            var body = document.body;

            // Set new size
            body.style.width = "800px";


        }
    </script>
@endsection
