<?php
$this->load->view('partial/header');
?>

<!--<style type="text/css">-->
<!--    html, body, #map-canvas {-->
<!--        height: 100%;-->
<!--        margin: 0;-->
<!--        padding: 0;-->
<!--    }-->
<!--</style>-->
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwzcJ-f3DSVnAuTLE0zpTw24Mx2e5G1LM">
</script>
<script type="text/javascript">
    var map;
    function initialize() {
        var mapOptions = {
            center: {lat: 6.9154952, lng: 79.98},
            zoom: 11
        };
        map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>

</head>
<body>

<div class="container">
    <div class="row">
        <?php $this->load->view('partial/navbar', $user); ?>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <table id="waste_locations" class="table table-responsive table-bordered">
                <thead>
                <td>Type</td>
                <td>Added on</td>
                <td>Address</td>
                <td>Action</td>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-12">
                    <div class="btn-group pull-right" style="padding-bottom: 5px">
                        <button data-type="all" class="btn-type btn btn-default">All</button>
                        <button data-type="paper" class="btn-type btn btn-default">Paper</button>
                        <button data-type="glass" class="btn-type btn btn-default">Glass</button>
                        <button data-type="plastic" class="btn-type btn btn-default">Plastic</button>
                        <button data-type="metal" class="btn-type btn btn-default">Metal</button>
                        <button data-type="ewaste" class="btn-type btn btn-default">e-Waste</button>
                    </div>
                </div>
            </div>
            <div style="height: 450px;" class="well well-sm" id="map-canvas"></div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Enter PIN</h4>
            </div>
            <form action="<?php echo base_url('user/enterPIN'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="">PIN:</label>
                        <input type="text" name="PIN" id="PIN" class="form-control"/>
                        <input type="text" name="id" id="id" class="form-control hidden" hidden="hidden"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-success" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>

</body>
<script type="text/javascript">
    var markers = [];
    var add_ = "";
    $('.btn-type').click(function (e) {
        clearMarkers();
        var type = $(this).data('type');
        set_markers(type);
    });

    $(document).ready(function () {
        set_markers('all');
    });

    $("#test").click(function () {
        var infowindow = new google.maps.InfoWindow({
            content: "test"
        });
        infowindow.open(map, markers[1]);
    });

    $(document).on('click', '.collected_btn', function () {
        var item_id = $(this).data('id');
        $('#id').val(item_id);
        $('#myModal').modal('toggle');
    });

    function set_markers(type) {
        $.getJSON("<?= base_url("user/get_waste_locations/"); ?>", {
            type: type,
            gcid: <?php echo $user->gcid; ?>,
            ajax: 'true'
        }, function (j) {
            for (var i = 0; i < j.length; i++) {
                var myLatlng = new google.maps.LatLng(j[i].longitude, j[i].latitude);
                addMarker(myLatlng);
                setAllMap(map);
                update_table(j[i].longitude, j[i].latitude, j[i].type, j[i].created_at, j[i].id);
            }
        });
    }

    function set_table_body(type, created_at, address, id) {
        newRowContent = "<tr><td>" + type + "</td><td>" + created_at + "</td><td>" + address + "</td>" +
        "<td><button data-id='" + id + "' class='collected_btn btn btn-success'><span class='glyphicon glyphicon-ok'></span> Collected</button></td>" +
        "</tr>";
        $("#waste_locations tbody").append(newRowContent);
    }

    function update_table(lng, lat, type, created_at, id) {
        $.getJSON("http://maps.googleapis.com/maps/api/geocode/json", {
            latlng: lng + "," + lat,
            sensor: true
        }, function (j) {
            set_table_body(type, created_at, j.results[0].formatted_address, id);
        });
    }

    function addMarker(location) {
        var marker = new google.maps.Marker({
            position: location,
            animation: google.maps.Animation.DROP,
            map: map
        });
        markers.push(marker);
    }

    function setAllMap(map) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }

    function clearMarkers() {
        setAllMap(null);
        markers = [];
        $("#waste_locations tbody").html('');

    }
</script>
</html>
