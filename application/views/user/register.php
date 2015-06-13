<?php
$this->load->view('partial/header');
$this->load->helper(array('form', 'bootstrapForm'));
?>
<style>
    html, body, #map-canvas {
        height: 300px;
        margin: 0px;
        padding: 0px
    }
</style>
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwzcJ-f3DSVnAuTLE0zpTw24Mx2e5G1LM">
</script>
<script type="text/javascript">
    function initialize() {
        var mapOptions = {
            center: {lat: 6.9154952, lng: 79.8661214},
            zoom: 10
        };
        document.getElementById('latitude').value = 6.9154952;
        document.getElementById('longitude').value = 79.8661214;

        var map = new google.maps.Map(document.getElementById('map-canvas'),
                mapOptions);
        var marker = new google.maps.Marker({
            position: map.getCenter(),
            map: map,
            draggable: true
        });
        google.maps.event.addListener(marker, "dragend", function (event) {
            document.getElementById('latitude').value = event.latLng.lat();
            document.getElementById('longitude').value = event.latLng.lng();

        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>
<body>
    <div class="container">
        <div style="margin-top: 20px" class="row clearfix">
            <div class="col-lg-2"></div>
            <div class="col-lg-8 well">
                <center><h1 class="h1">Register as a collector</h1></center>
                <?php
                if (validation_errors() != '') {
                    ?>
                    <label class="alert alert-danger"><?php echo validation_errors(); ?></label>
                    <?php
                }
                echo form_open('user/register_collector', array('role' => 'form'));
                echo form_input_div(array('id' => 'firstName', 'name' => 'firstName', 'type' => 'text', 'placeholder' => 'First Name', 'class' => 'form-control', 'label' => 'First Name'), set_value('firstName'));
                echo form_input_div(array('id' => 'lastName', 'name' => 'lastName', 'type' => 'text', 'placeholder' => 'Last Name', 'class' => 'form-control', 'label' => 'Last Name'), set_value('lastName'));
                echo form_input_div(array('id' => 'username', 'name' => 'username', 'type' => 'text', 'placeholder' => 'Username', 'class' => 'form-control', 'label' => 'Username'), set_value('username'));
                echo form_input_div(array('id' => 'organization', 'name' => 'organization', 'type' => 'text', 'placeholder' => 'Organization', 'class' => 'form-control', 'label' => 'Organization'), set_value('organization'));
                echo form_input_div(array('id' => 'password', 'name' => 'password', 'type' => 'password', 'placeholder' => 'Password', 'class' => 'form-control', 'label' => 'Password'));
                echo form_input_div(array('id' => 'passwordConfirm', 'name' => 'passwordConfirm', 'type' => 'password', 'placeholder' => 'Confirm Password', 'class' => 'form-control', 'label' => 'Confirm Password'));
                echo form_input_div(array('id' => 'city', 'name' => 'city', 'type' => 'text', 'placeholder' => 'City', 'class' => 'form-control', 'label' => 'City'),set_value('city'));
                ?>
                <div class='form-group'>
                    <label for="map-canvas">Location of Collection point</label>
                    <div id="map-canvas"></div>
                    <input type="text" id="latitude" name="latitude" hidden="hidden"/>
                    <input type="text" id="longitude" name="longitude" hidden="hidden"/>
                </div>
                <div class="form-group">
                    <label for="map-canvas">Collectable types</label>
                    <?php
                    foreach ($types->result() as $collectable) {
                        echo "<input type='checkbox' name='types[]' value='$collectable->id'/> $collectable->type &nbsp";
                    }
                    ?>
                </div>
                <?php
                echo form_submit(array('id' => 'submit', 'name' => 'submit', 'class' => 'btn btn-success'), 'Register', 'style="margin-left: 5px"');
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</body>
</html>
