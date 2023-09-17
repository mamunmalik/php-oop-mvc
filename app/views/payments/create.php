<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-6">
                <h1>Form Submission</h1>
                <form id="submissionForm" class="form">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="amount">Amount:</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="number" id="amount" name="amount">
                            <div id="amountError" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="buyer">Buyer:</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="buyer" name="buyer">
                            <div id="buyerError" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="receipt_id">Receipt Id:</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="receipt_id" name="receipt_id">
                            <div id="receiptIdError" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="receipt_id">Items:</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="items" name="items">
                            <div id="itemsError" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="receipt_id">Buyer Email:</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="email" id="buyer_email" name="buyer_email">
                            <div id="buyerEmailError" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="note">Note:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="note" name="note"></textarea>
                            <div id="noteError" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="city">City:</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="city" name="city">
                            <div id="cityError" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="phone">Phone:</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="number" id="phone" name="phone" maxlength="12">
                            <div id="phoneError" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="entry_by">entry_by:</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="number" id="entry_by" name="entry_by">
                            <div id="entryByError" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="pull-right">
                        <button type="button" id="submitBtn" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $("#submitBtn").on("click", function() {
            if (!hasSubmittedToday()) {
                if (!validateForm()) {
                    return;
                }
                var formData = $('#submissionForm').serialize();
                // AJAX POST request
                $.ajax({
                    type: "POST",
                    url: "store",
                    data: formData,
                    success: function(response) {
                        var res = JSON.parse(response);
                        console.log(res);
                        if (res.error) {
                            Object.keys(res.errors).forEach(function(key) {
                                $("#" + key + "Error").text(res.errors[key])
                                    .show();
                            });
                        } else if (!res.error) {
                            alert(res.message);
                            var currentTimestamp = new Date().getTime();
                            setCookie("today_submission", currentTimestamp.toString(),
                                24); // 24 hours expiration
                            window.location = "<?php echo URLROOT ?>";
                        } else {
                            alert("Something wrong! plz try again later");
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle error response
                        console.error(errorThrown);
                    }
                });
            } else {
                alert("You have already submitted within the last 24 hours.");
                window.location = "<?php echo URLROOT ?>";
            }
        });

        $("#phone").on("keyup", function() {
            var input = this;
            var phoneNumber = input.value.trim();

            phoneNumber = phoneNumber.replace(/\D/g, '');

            if (!phoneNumber.startsWith('880')) {
                phoneNumber = '880' + phoneNumber;
            }

            if (phoneNumber.length > 13) {
                phoneNumber = phoneNumber.slice(0, 13);
            }

            input.value = phoneNumber;
        })

        function hasSubmittedToday() {
            var lastSubmissionTimestamp = getCookie("today_submission");
            if (lastSubmissionTimestamp) {
                var currentTime = new Date().getTime();
                var lastSubmissionTime = parseInt(lastSubmissionTimestamp);

                // Calculate the time difference in milliseconds
                var timeDifference = currentTime - lastSubmissionTime;

                // Define the time limit for preventing multiple submissions (24 hours)
                var timeLimit = 24 * 60 * 60 * 1000; // 24 hours in milliseconds

                return timeDifference < timeLimit;
            }
            return false;
        }

        // Validation function
        function validateForm() {
            var isValid = true;
            // Validate Amount (only numbers)
            var amount = $("#amount").val();
            if (!/^\d+$/.test(amount)) {
                isValid = false;
                $("#amountError").text("Amount must contain only numbers.").show();
            } else {
                $("#amountError").text("");
            }

            // Validate Buyer (only text, spaces, and numbers, not more than 20 characters)
            var buyer = $("#buyer").val();
            if (!/^[a-zA-Z0-9\s]{0,20}$/.test(buyer)) {
                isValid = false;
                $("#buyerError").text(
                    "Buyer should contain only text, spaces, and numbers (up to 20 characters).").show();
            } else {
                $("#buyerError").text("");
            }

            // Validate Receipt Id (only text)
            var receiptId = $("#receipt_id").val();
            if (!/^[A-Za-z]+$/.test(receiptId)) {
                isValid = false;
                $("#receiptIdError").text("Receipt Id should contain only text.").show();
            } else {
                $("#receiptIdError").text("");
            }

            // Validate buyer email (only email)
            var buyerEmail = $("#buyer_email").val().toLowerCase();
            if (!
                /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                .test(buyerEmail)) {
                isValid = false;
                $("#buyerEmailError").text("Please enter a valid email address.").show();
            } else {
                $("#buyerEmailError").text("");
            }

            // Validate note (only text)
            var note = $("#note").val();
            if (!/^[\s\S]{1,255}(\s+[\s\S]{1,255}){0,29}$/.test(note)) {
                isValid = false;
                $("#noteError").text("Note can't exceed 30 words.").show();
            } else {
                $("#noteError").text("");
            }

            // Validate Receipt Id (only text and spaces)
            var city = $("#city").val();
            if (!/^[A-Za-z\s]+$/.test(city)) {
                isValid = false;
                $("#cityError").text("City should contain only text and spaces.").show();
            } else {
                $("#cityError").text("");
            }

            // Validate phone (only number)
            var phone = $("#phone").val();
            if (!/^\d+$/.test(phone)) {
                isValid = false;
                $("#phoneError").text("Phone should contain only numbers.").show();
            } else {
                $("#phoneError").text("");
            }

            // Validate entry by (only number)
            var entryBy = $("#entry_by").val();
            if (!/^\d+$/.test(entryBy)) {
                isValid = false;
                $("#entryByError").text("Entry By should contain only numbers.").show();
            } else {
                $("#entryByError").text("");
            }

            return isValid;
        }

        function getCookie(cookieName) {
            var name = cookieName + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var cookieArray = decodedCookie.split(';');
            for (var i = 0; i < cookieArray.length; i++) {
                var cookie = cookieArray[i];
                while (cookie.charAt(0) == ' ') {
                    cookie = cookie.substring(1);
                }
                if (cookie.indexOf(name) == 0) {
                    return cookie.substring(name.length, cookie.length);
                }
            }
            return null;
        }

        function setCookie(cookieName, cookieValue, expirationHours) {
            var d = new Date();
            d.setTime(d.getTime() + (expirationHours * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cookieName + "=" + cookieValue + "; " + expires + "; path=/";
        }

    });
    </script>
</body>

</html>