<?php
$this->load->view('partial/header');
$this->load->helper(array('form', 'bootstrapForm', 'htmlgenerator'));
?>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-6">
                <?php
                echo form_open('user/update');
                echo form_input(array('id' => 'gcid', 'name' => 'gcid', 'type' => 'text', 'class' => 'form-control hidden', 'hidden' => 'hidden'), $fname);
                echo form_input_div(array('id' => 'fname', 'name' => 'fname', 'type' => 'text', 'placeholder' => 'First Name', 'class' => 'form-control', 'label' => 'First Name'), $fname);
                echo form_input_div(array('id' => 'lname', 'name' => 'lname', 'type' => 'text', 'placeholder' => 'Last Name', 'class' => 'form-control', 'label' => 'Last Name'), $lname);
                echo form_input_div(array('id' => 'city', 'name' => 'city', 'type' => 'text', 'placeholder' => 'City', 'class' => 'form-control', 'label' => 'City'), $city);
                echo form_input_div(array('id' => 'type', 'name' => 'type', 'type' => 'text', 'placeholder' => 'Waste Type', 'class' => 'form-control', 'label' => 'Waste Type'), $type);
                echo form_input_div(array('id' => 'number', 'name' => 'number', 'type' => 'text', 'placeholder' => 'Number', 'class' => 'form-control', 'label' => 'Number'), $number);
                echo form_input_div(array('id' => 'password', 'name' => 'password', 'type' => 'text', 'placeholder' => 'Password', 'class' => 'form-control', 'label' => 'Password'), '');
                echo form_input_div(array('id' => 'password2', 'name' => 'password2', 'type' => 'text', 'placeholder' => 'Password Confirm', 'class' => 'form-control', 'label' => 'Password Confirm'), '');
                echo form_submit(array('id' => 'submit', 'name' => 'submit', 'class' => 'btn btn-success'), 'Update');
                ?>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6">
                <table class="table table-bordered table-hover table-responsive">
                    <thead>
                    <th>Number</th>
                    <th>Lan</th>
                    <th>Lon</th>
                    <th>gType</th>
                    <th>Collected</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($waste->result() as $value) {
                            echo '<tr>';
                            echo "<td>$value->number</td>";
                            echo "<td>$value->lan</td>";
                            echo "<td>$value->lon</td>";
                            echo "<td>$value->gtype</td>";
                            echo "<td>$value->collected</td>";
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
