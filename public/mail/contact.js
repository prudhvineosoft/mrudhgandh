$(function () {

    $("#contactForm input, #contactForm textarea").jqBootstrapValidation({
        preventSubmit: true,
        submitError: function ($form, event, errors) {
        },
        submitSuccess: function ($form, event) {
            event.preventDefault();
            var name = $("input#name").val();
            var email = $("input#email").val();
            var subject = $("input#subject").val();
            var message = $("textarea#message").val();

            $this = $("#sendMessageButton");
            $this.prop("disabled", true);

            $.ajax({
                url: "/contact-submit",
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    name: name,
                    email: email,
                    subject: subject,
                    message: message,
                    _token: $('#token').val()
                },
                cache: false,
                success: function () {
                    $('#success').html("<div class='alert alert-success'>");
                    $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                            .append("</button>");
                    $('#success > .alert-success')
                            .append("<strong>Your message has been sent. </strong>");
                    $('#success > .alert-success')
                            .append('</div>');
                    $('#contactForm').trigger("reset");
                },
                error: function () {
                    $('#success').html("<div class='alert alert-danger'>");
                    $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                            .append("</button>");
                    $('#success > .alert-danger').append($("<strong>").text("Sorry " + name + ", it seems that our mail server is not responding. Please try again later!"));
                    $('#success > .alert-danger').append('</div>');
                    $('#contactForm').trigger("reset");
                },
                complete: function () {
                    setTimeout(function () {
                        $this.prop("disabled", false);
                    }, 1000);
                }
            });
        },
        filter: function () {
            return $(this).is(":visible");
        },
    });

    $("#PlaceOrder input, #PlaceOrder textarea , #PlaceOrder select").jqBootstrapValidation({
        preventSubmit: true,
        submitError: function ($form, event, errors) {
        },
        submitSuccess: function ($form, event) {
            event.preventDefault();
            $this = $("#placeOrderbutton");
            $this.prop("disabled", true);

            $.ajax({
                url: "/place-order",
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: $form.serialize(),
                cache: false,
                success: function (result) {

                    var options = JSON.parse(result.data);
                    console.log("options",options);
                    options.handler = function (response){
                        console.log("response",response);
                        $('#razorpay_payment_id').val(response.razorpay_payment_id);
                        $('#razorpay_signature').val(response.razorpay_signature);
                        $("#razorpayform").submit()
                    };
                    
                    options.theme.image_padding = false;

                    options.modal = {
                        ondismiss: function() {
                            console.log("This code runs when the popup is closed");
                        },
                        // Boolean indicating whether pressing escape key 
                        // should close the checkout form. (default: true)
                        escape: true,
                        // Boolean indicating whether clicking translucent blank
                        // space outside checkout form should close the form. (default: false)
                        backdropclose: false
                    };

                    var rzp = new Razorpay(options);
                    rzp.open();
                },
                error: function () {
                    
                },
                complete: function () {
                    setTimeout(function () {
                        $this.prop("disabled", false);
                    }, 1000);
                }
            });
        },
        filter: function () {
            return $(this).is(":visible");
        },
    });

    $("a[data-toggle=\"tab\"]").click(function (e) {
        e.preventDefault();
        $(this).tab("show");
    });
});

$('#name').focus(function () {
    $('#success').html('');
});
