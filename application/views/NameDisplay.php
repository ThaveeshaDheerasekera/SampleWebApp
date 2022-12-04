<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sample Web App</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/NameDisplayStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.0.0/backbone-min.js"></script>
</head>

<body>
    <div class="main-container" id="main-container">
        <div id="container">
            <h1>Welcome to Sample Web App</h1>
        </div>
        <hr>
        <br><br>

        <div class="table" id="table">
            <h2>People</h2>
            <table>
                <tr>
                    <th>PersonID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Telephone</th>
                </tr>

                <?php foreach($people as $row) { ?>
                <tr>
                    <td><?=$row->personID?></td>
                    <td><?=$row->firstName?> <?=$row->lastName?></td>
                    <td><?=$row->address?></td>
                    <td><?=$row->telephone?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <br><br><br>

        <p id="createMsg"></p>

        <div class="form">
            <div class="input">
                <h2>Create Person</h2>
                <form>
                    <label for="firstName">First Name</label>
                    <input type="text" name="firstName" id="firstName">
                    <br>

                    <label for="lastName">Last Name</label>
                    <input type="text" name="lastName" id="lastName">
                    <br>

                    <label for="address">Address</label>
                    <input type="text" name="address" id="address">
                    <br>

                    <label for="telephone">TP Number</label>
                    <input type="text" name="telephone" id="telephone">
                    <br>

                    <input type="submit" value="Create" id="create">
                    <br>
                </form>
            </div>
            <br><br><br>

            <div class="edit-delete">
                <h2>Edit/Delete Person</h2>
                <form>
                    <label for="edit">Type in id to edit/delete</label>
                    <input type="text" name="personID" id="personID">
                    <br>

                    <input type="submit" value="Delete" id="delete">
                    <input type="submit" value="Edit" id="edit">
                    <br>
                </form>
            </div>
            <br><br>

            <div class="edit-form" id="edit-form">
                <form>
                    <label for="editFirstName">Edit First Name</label>
                    <input type="text" name="firstName" id="editFirstName">
                    <br>

                    <label for="editLastName">Edit Last Name</label>
                    <input type="text" name="lastName" id="editLastName">
                    <br>

                    <label for="editAddress">Edit Address</label>
                    <input type="text" name="address" id="editAddress">
                    <br>

                    <label for="editTelephone">Edit TP Number</label>
                    <input type="text" name="telephone" id="editTelephone">
                    <br>

                    <input type="submit" value="Update" id="update">
                    <br>
                </form>
            </div>

            <script>
                //            Add new person to the database
                $(document).ready(function() {
                    $("#create").click(function(event) {
                        event.preventDefault();

                        var firstName = $("input#firstName").val();
                        var lastName = $("input#lastName").val();
                        var address = $("input#address").val();
                        var telephone = parseInt($("input#telephone").val());

                        $.ajax({
                            method: "POST",
                            url: "<?php echo base_url(); ?>index.php/Person/person",
                            datatype: 'JSON',
                            data: {
                                firstName: firstName,
                                lastName: lastName,
                                address: address,
                                telephone: telephone
                            },
                            success: function(data) {
                                console.log(firstName, lastName, address, telephone);
                                $("#table").load(location.href + " #table");
                                $("#input").load(location.href + " #input")
                                //                                alert("A New Person Created! \nName: \"" + firstName + " " + lastName);
                                $("input#firstName").val("");
                                $("input#lastName").val("");
                                $("input#address").val("");
                                $("input#telephone").val("");
                            }
                        });
                    });
                });

                //            Delete an existing person in the database by personID
                $(document).ready(function() {
                    $("#delete").click(function(event) {
                        event.preventDefault();

                        var personID = $("input#personID").val();

                        $.ajax({
                            method: "GET",
                            url: "<?php echo base_url(); ?>index.php/Person/person",
                            datatype: 'JSON',
                            data: {
                                personID: personID
                            },
                            success: function(data) {
                                console.log(personID);
                                $("#table").load(location.href + "#table");
                                alert("The Person corresponding to the ID Number: " + personID + " is deleted...!");
                                $("input#personID").val("");
                            }
                        });
                    });
                });

                //            Edit an existing person in the database by personID
                $(document).ready(function() {
                    $("#edit").click(function(event) {
                        event.preventDefault();

                        var personID = $("input#personID").val();

                        $.ajax({
                            method: "GET",
                            url: "<?php echo base_url(); ?>index.php/Person/user",
                            datatype: 'JSON',
                            data: {
                                personID: personID
                            },
                            success: function(data) {
                                $.each(JSON.parse(data), function(personID, firstName, lastName, address, telephone) {
                                    console.log(personID, firstName, lastName, address, telephone);
                                    $("#edit-form").show();
                                    $("input#editFirstName").val(firstName[0]);
                                    $("input#editLastName").val(firstName[1]);
                                    $("input#editAddress").val(firstName[2]);
                                    $("input#editTelephone").val(firstName[3]);
                                });

                            }
                        });
                    });
                });

                //            Update the selected person in the database by personID
                $(document).ready(function() {
                    $("#update").click(function(event) {
                        event.preventDefault();

                        var personID = $("input#personID").val();
                        var firstName = $("input#editFirstName").val();
                        var lastName = $("input#editLastName").val();
                        var address = $("input#editAddress").val();
                        var telephone = parseInt($("input#editTelephone").val());

                        $.ajax({
                            method: "POST",
                            url: "<?php echo base_url(); ?>index.php/Person/user",
                            datatype: 'JSON',
                            data: {
                                personID: personID,
                                firstName: firstName,
                                lastName: lastName,
                                address: address,
                                telephone: telephone
                            },
                            success: function(data) {
                                console.log(personID, firstName, lastName, address, telephone);
                                $("#table").load(location.href + "#table");
                                //                                alert("The Person conrrsponding to the PersonID " + personID + " is Updated! \nName: \"" + firstName + " " + lastName);
                                $('#createMsg').html('Name ' + this.model.get('name') + ' and address ' + this.model.get('address') + ' has been created').show().fadeOut(5000);
                                $("#main-container").load(location.href, "#main-container");
                            }
                        });
                    });
                });

                //            Backbone Js
                $(document).ready(function() {

                    var Create = Backbone.Model.extend({
                        url: function() {
                            var link = "<?php echo base_url(); ?>index.php/Person/person?firstName=" + this.get("firstName");
                            return link;
                        },
                        defaults: {
                            firstName: null,
                            lastName: null,
                            address: null,
                            telephone: null
                        }
                    });

                    var createModel = new Create();

                    var DisplayView = Backbone.View.extend({
                        el: "#main-container",
                        model: createModel,
                        initialize: function() {
                            this.listenTo(this.model, "sync change", this.gotData);
                        },
                        events: {
                            "click #create": "getData"
                        },

                        getData: function(event) {
                            var firstName = $('input#firstName').val();
                            var lastName = $('input#lastName').val();
                            var address = $('input#address').val();
                            this.model.set({
                                firstName: firstName,
                                lastName: lastName,
                                address: address
                            });
                            this.model.fetch();
                        },

                        gotData: function() {
                            alert('Name ' + this.model.get('firstName') + ' and address ' + this.model.get('address') + ' has been created.');
                        }
                    });

                    var displayView = new DisplayView();

                });

            </script>
        </div>
    </div>
</body>

</html>
