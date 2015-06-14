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
        <div class="col-lg-7 col-md-7">
            <div class="row">
                <div class="col-lg-12">
                    <h3>Collection Requests <br/>
                        <small>The waste collection requests placed by the households and Greeen Bins are listed here
                            according to the type. Enter the PIN receiving from the requester to complete the collection
                            process.
                        </small>
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="btn-group pull-left" style="padding-bottom: 5px">
                        <button data-type="all" class="btn-type btn btn-default">All</button>
                        <button data-type="paper" class="btn-type btn btn-default">Paper</button>
                        <button data-type="glass" class="btn-type btn btn-default">Glass</button>
                        <button data-type="plastic" class="btn-type btn btn-default">Plastic</button>
                        <button data-type="metal" class="btn-type btn btn-default">Metal</button>
                        <button data-type="ewaste" class="btn-type btn btn-default">e-Waste</button>
                        <a href="<?php echo base_url('index.php/user/dashboard_bin'); ?>" class="btn-type btn btn-default">Greeen Bin Only</a>
                    </div>
                </div>
            </div>

            <table id="waste_locations" class="table table-responsive table-bordered table-hover">
                <thead>
                <td class="text-center">Type</td>
                <td class="text-center">Date</td>
                <td class="text-center">Time</td>
                <td class="text-center" style="width: 118px;">Address</td>
                <td class="text-center">Action</td>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
        <div class="col-lg-5 col-md-5">

            <div style="height: 500px;" class="well well-sm" id="map-canvas"></div>
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
                <h4 class="modal-title" id="myModalLabel">Enter PIN<br><small>Please enter the PIN received by the requester on receiving garbage.</small></h4>
            </div>
            <form action="<?php echo base_url('user/enterPIN'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="">PIN:</label>
                        <input type="text" name="PIN" id="PIN" class="form-control" placeholder="XXXX"/>
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

    $(document).on('click', '.view_point', function () {
        var index = $(this).data('index');
        map.setCenter(markers[index].getPosition());
    });

    function set_markers(type) {
        $.getJSON("<?= base_url("index.php/user/get_waste_locations/"); ?>", {
            type: type,
            gcid: <?php echo $user->gcid; ?>,
            ajax: 'true'
        }, function (j) {
            for (var i = 0; i < j.length; i++) {
                var myLatlng = new google.maps.LatLng(j[i].longitude, j[i].latitude);
                addMarker(myLatlng);
                setAllMap(map);
                update_table(j[i].longitude, j[i].latitude, j[i].type, j[i].created_at, j[i].id, i);
            }
        });
    }

    function set_table_body(type, created_at, address, id, i) {
        newRowContent = "<tr><td>" + type + "</td><td>" + created_at.substring(0, 10) + "</td><td>" + created_at.substring(11) + "</td><td>" + address + "</td>" +
        "<td><div class='btn-group'><button data-id='" + id + "' class='collected_btn btn btn-success btn-sm'><span class='glyphicon glyphicon-ok'></span> Mark as Collected</button>" +
        "<button data-index='" + i + "' style='margin-left:5px' class='view_point btn btn-default btn-sm'><span class='glyphicon glyphicon-play'></span></button></div></td>" +
        "</tr>";
        $("#waste_locations tbody").append(newRowContent);
    }

    function update_table(lng, lat, type, created_at, id, i) {
        $.getJSON("http://maps.googleapis.com/maps/api/geocode/json", {
            latlng: lng + "," + lat,
            sensor: true
        }, function (j) {
            set_table_body(type, created_at, j.results[0].formatted_address, id, i);
        });
    }

    function addMarker(location) {
        var marker = new google.maps.Marker({
            position: location,
            animation: google.maps.Animation.DROP,
            map: map,
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
