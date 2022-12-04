$(document).ready(function () {
    $("#create").click(function (event) {
        event.preventDefault();

        var firstName = $("input#firstName").val();
        var lastName = $("input#lastName").val();
        var address = $("input#address").val();
        var telephone = parseInt($("input#telephone").val());

        $.ajax({
            method: "POST",
            url: $(this).data('base-url') + "index.php/Person/createPerson",
            datatype: 'JSON',
            data: {
                firstName: firstName,
                lastName: lastName,
                address: address,
                telephone: telephone
            },
            success: function (data) {
                console.log(firstName, lastName, address, telephone);
            }
        });
    });
});