<?php
$this->load->view('partial/header');
?>
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwzcJ-f3DSVnAuTLE0zpTw24Mx2e5G1LM">
</script>


</head>
<body>

<div class="container">
    <div class="row">
        <nav class="navbar well-sm well">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2">
                        <a class="" href="<?php echo base_url('index.php'); ?>"><img
                                src="<?php echo base_url('assests/images/Logo.png') ?>" class="img-responsive"
                                width="150px"/></a>
                    </div>
                    <div class="col-md-8"><h1 class="text-center">Dashboard</h1></div>
                    <div class="col-md-2">
                        <ul class="nav navbar-nav navbar-right" style="vertical-align: middle">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false"><?php echo $user->first_name; ?>
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">My Profile</a></li>
                                    <li><a href="<?php echo base_url('index.php/user/logout'); ?>">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-7">
            <div class="row">
                <div class="col-lg-3">
                    <!--                    user Image-->
                    <img src="<?php echo base_url('assests/images/male_user_icon_clip_art.jpg') ?>" alt="" class="img-responsive"/>

                </div>
                <div class="col-lg-7 ">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1><?= $user->first_name . " " . $user->last_name ?></h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <img src="<?php echo base_url('assests/images/master.png') ?>" alt="" class="img-responsive"/>
                            <!--                            trophy-->
                        </div>
                        <div class="col-lg-6">
                            <br/>
                            <br/>
                            <br/>
                            <img src="<?php echo base_url('assests/images/facebook-share-button.png') ?>" alt="" class="img-responsive"/>
                            <img src="<?php echo base_url('assests/images/twitter-share-button.png') ?>" alt="" class="img-responsive"/>

                        </div>

                    </div>
                    <h1>Past Recycled Items</h1>
                    <ul class="list-group">
                        <?php foreach($recycles as $recycle): ?>
                        <li class="list-group-item"><?=$recycle->type?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-lg-1 ">
            <h2 class="text-center">Tropies</h2>
            <img src="<?php echo base_url('assests/images/newbie.png') ?>" alt="" class="img-responsive"/>
            <img src="<?php echo base_url('assests/images/force.png') ?>" alt="" class="img-responsive"/>
            <img src="<?php echo base_url('assests/images/captain.png') ?>" alt="" class="img-responsive"/>

        </div>
        <div class="col-lg-1 ">
            <h2 class="text-center">Top 10</h2>
            <img src="<?php echo base_url('assests/images/male_user_icon_clip_art.jpg') ?>" alt="" class="img-rounded img-thumbnail img-responsive"/>
            <img src="<?php echo base_url('assests/images/male_user_icon_clip_art.jpg') ?>" alt="" class="img-rounded img-thumbnail img-responsive"/>
            <img src="<?php echo base_url('assests/images/male_user_icon_clip_art.jpg') ?>" alt="" class="img-rounded img-thumbnail img-responsive"/>
        </div>
        <div class="col-lg-2">
            <h2 class="text-center">Redeem your points at</h2>
            <img src="<?php echo base_url('assests/images/Dialog.jpg') ?>" alt="" class="img-responsive"/>
            <img src="<?php echo base_url('assests/images/win_cinema_tickets_sitges.png') ?>" alt="" class="img-responsive"/>
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
                <h4 class="modal-title" id="myModalLabel">Enter PIN<br>
                    <small>Please enter the PIN received by the requester on receiving garbage.</small>
                </h4>
            </div>
            <form action="<?php echo base_url('index.php/user/enterPIN'); ?>" method="POST">
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
