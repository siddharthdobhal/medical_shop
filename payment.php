
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Payment</title>
    </head>
    <body>
        
        
        
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<style>
body {  background:url("my images/bg2.jpg");}

/* CSS for Credit Card Payment form */
.credit-card-box .panel-title {
    display: inline;
    font-weight: bold;
}
.credit-card-box .form-control.error {
    border-color: red;
    outline: 0;
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(255,0,0,0.6);
}
.credit-card-box label.error {
  font-weight: bold;
  color: red;
  padding: 2px 8px;
 // margin-top: 2px;
}
.credit-card-box .payment-errors {
  font-weight: bold;
  color: red;
  padding: 2px 8px;
 // margin-top: 2px;
}
.credit-card-box label {
    display: block;
}
/* The old "center div vertically" hack */
.credit-card-box .display-table {
    display: table;
}
.credit-card-box .display-tr {
    display: table-row;
}
.credit-card-box .display-td {
    display: table-cell;
    vertical-align: middle;
    width: 50%;
}
/* Just looks nicer */
.credit-card-box .panel-heading img {
    min-width: 180px;
}
</style>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script>

var $form = $('#payment-form');
$form.find('.subscribe').on('click', payWithStripe);

/* If you're using Stripe for payments */
function payWithStripe(e) {
    e.preventDefault();
    
    /* Abort if invalid form data */
    if (!validator.form()) {
        return;
    }

    /* Visual feedback */
    $form.find('.subscribe').html('Validating <i class="fa fa-spinner fa-pulse"></i>').prop('disabled', true);

    var PublishableKey = 'pk_test_6pRNASCoBOKtIshFeQd4XMUh'; // Replace with your API publishable key
    Stripe.setPublishableKey(PublishableKey);
    
    /* Create token */
    var expiry = $form.find('[name=cardExpiry]').payment('cardExpiryVal');
    var ccData = {
        number: $form.find('[name=cardNumber]').val().replace(/\s/g,''),
        cvc: $form.find('[name=cardCVC]').val(),
        exp_month: expiry.month, 
        exp_year: expiry.year
    };
    
    Stripe.card.createToken(ccData, function stripeResponseHandler(status, response) {
        if (response.error) {
            /* Visual feedback */
            $form.find('.subscribe').html('Try again').prop('disabled', false);
            /* Show Stripe errors on the form */
            $form.find('.payment-errors').text(response.error.message);
            $form.find('.payment-errors').closest('.row').show();
        } else {
            /* Visual feedback */
            $form.find('.subscribe').html('Processing <i class="fa fa-spinner fa-pulse"></i>');
            /* Hide Stripe errors on the form */
            $form.find('.payment-errors').closest('.row').hide();
            $form.find('.payment-errors').text("");
            // response contains id and card, which contains additional card details            
            console.log(response.id);
            console.log(response.card);
            var token = response.id;
            // AJAX - you would send 'token' to your server here.
            $.post('/account/stripe_card_token', {
                    token: token
                })
                // Assign handlers immediately after making the request,
                .done(function(data, textStatus, jqXHR) {
                    $form.find('.subscribe').html('Payment successful <i class="fa fa-check"></i>');
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    $form.find('.subscribe').html('There was a problem').removeClass('success').addClass('error');
                    /* Show Stripe errors on the form */
                    $form.find('.payment-errors').text('Try refreshing the page and trying again.');
                    $form.find('.payment-errors').closest('.row').show();
                });
        }
    });
}
/* Fancy restrictive input formatting via jQuery.payment library*/
$('input[name=cardNumber]').payment('formatCardNumber');
$('input[name=cardCVC]').payment('formatCardCVC');
$('input[name=cardExpiry').payment('formatCardExpiry');

/* Form validation using Stripe client-side validation helpers */
jQuery.validator.addMethod("cardNumber", function(value, element) {
    return this.optional(element) || Stripe.card.validateCardNumber(value);
}, "Please specify a valid credit card number.");

jQuery.validator.addMethod("cardExpiry", function(value, element) {    
    /* Parsing month/year uses jQuery.payment library */
    value = $.payment.cardExpiryVal(value);
    return this.optional(element) || Stripe.card.validateExpiry(value.month, value.year);
}, "Invalid expiration date.");

jQuery.validator.addMethod("cardCVC", function(value, element) {
    return this.optional(element) || Stripe.card.validateCVC(value);
}, "Invalid CVC.");

validator = $form.validate({
    rules: {
        cardNumber: {
            required: true,
            cardNumber: true            
        },
        cardExpiry: {
            required: true,
            cardExpiry: true
        },
        cardCVC: {
            required: true,
            cardCVC: true
        }
    },
    highlight: function(element) {
        $(element).closest('.form-control').removeClass('success').addClass('error');
    },
    unhighlight: function(element) {
        $(element).closest('.form-control').removeClass('error').addClass('success');
    },
    errorPlacement: function(error, element) {
        $(element).closest('.form-group').append(error);
    }
});

paymentFormReady = function() {
    if ($form.find('[name=cardNumber]').hasClass("success") &&
        $form.find('[name=cardExpiry]').hasClass("success") &&
        $form.find('[name=cardCVC]').val().length > 1) {
        return true;
    } else {
        return false;
    }
}

$form.find('.subscribe').prop('disabled', true);
var readyInterval = setInterval(function() {
    if (paymentFormReady()) {
        $form.find('.subscribe').prop('disabled', false);
        clearInterval(readyInterval);
    }
}, 250);
</script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>

<!-- If you're using Stripe for payments -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="container">
    <div class="row">
        <!-- You can make it whatever width you want. I'm making it full width
             on <= small devices and 4/12 page width on >= medium devices -->
        <div class="col-xs-4 col-md-4"></div>
        <div class="col-xs-4 col-md-4">
        
        
            <!-- CREDIT CARD FORM STARTS HERE -->
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                        <h3 class="panel-title display-td" >Payment Details</h3>
                        <div class="display-td" >                            
                            <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                        </div>
                    </div>                    
                </div>
                <div class="panel-body">
                    <form method="POST">
					
					

                        <input type="hidden" name="bookingdate" id="bookingdate" class="form-control" value = "<?php echo $_POST['bookingdate']; ?>">
						<input type="hidden" name = "customername" id = "customername" class="form-control" value = "<?php echo $_POST['username']; ?>">
						<input type="hidden" name="emailid" id="emailid" class="form-control" value = "<?php echo $_POST['emailid']; ?>">
						<input type="hidden" name="contactno" id="contact" class="form-control" value = "<?php echo $_POST['contact']; ?>">
						<input type="hidden" name="city" id="city" class="form-control" value = "<?php echo $_POST['city']; ?>">
						<input type="hidden" name="address" id="address" class="form-control" value = "<?php echo $_POST['address']; ?>">
						<input type="hidden" name="productname" id="productname" class="form-control" value = "<?php echo $_POST['productname']; ?>">
						<input type="hidden" name="sprice" id="sprice" class="form-control" value = "<?php echo $_POST['price'] ?>">
<input type="hidden" name="quantity" id="quantity" class="form-control" value="<?php echo $_POST['quantity'];?>">
		<input type="hidden" name="total" id="total" class="form-control" value="<?php echo $_POST['total'];?>">
		
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="cardNumber">CARD NUMBER</label>
                                    <div class="input-group">
                                        <input 
                                            type="tel"
                                            class="form-control"
                                            name="cardnumber"
                                            placeholder="Valid Card Number"
                                            autocomplete="cc-number"
                                             autofocus 
                                        />
                                        <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-7 col-md-7">
                                <div class="form-group">
                                    <label for="cardExpiry"><span class="hidden-xs">EXPIRATION</span><span class="visible-xs-inline">EXP</span> DATE</label>
                                    <input 
                                        type="tel" 
                                        class="form-control" 
                                        name="cardex"
                                        placeholder="MM / YY"
                                        autocomplete="cc-exp"
                                        
                                    />
                                </div>
                            </div>
                            <div class="col-xs-5 col-md-5 pull-right">
                                <div class="form-group">
                                    <label for="cardCVC">CVC CODE</label>
                                    <input 
                                        type="tel" 
                                        class="form-control"
                                        name="cvc"
                                        placeholder="CVC"
                                        autocomplete="cc-csc"
                                        
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
								
                                    <label for="couponCode">Amount In $</label>
                                    <input type="text" class="form-control" value="<?php echo $_POST['total'] ?>" name="amount" readonly/>
                                </div>
                            </div>                        
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <input type="submit" class="btn btn-success btn-lg btn-block" name="payment" value="payment">
							</div>
                        </div>
                        <div class="row" style="display:none;">
                            <div class="col-xs-12">
                                <p class="payment-errors"></p>
                            </div>
                        </div>
						
						<h1 class=text-center>OR</h1>
						<div class="row">
                            <div class="col-xs-12">
                                <input type="submit" class="btn btn-success btn-lg btn-block" name="cod" value="Cash On Delivery">
							</div>
                        </div>
                    </form>
			
                                
                                
                </div>
            </div>            
            <!-- CREDIT CARD FORM ENDS HERE -->
            
            
        </div>            
        
        
        
    </div>
</div>

       
    </body>
</html>



<?php

include "dbconfigure.php";





if(isset($_POST["payment"]))
{

$bookingdate=$_POST['bookingdate'];

$customername=$_POST['customername'];

$emailid=$_POST['emailid'];
$contact=$_POST['contactno'];
$city=$_POST['city'];
$address=$_POST['address'];
$productname=$_POST['productname'];
$sprice=$_POST['sprice'];
$quantity=$_POST['quantity'];
$total=$_POST['total'];
$query="insert into booking(bookingdate,customername,email,contact,city,address,productname,price,quantity,total,status) values('$bookingdate','$customername','$emailid','$contact','$city','$address','$productname','$sprice','$quantity','$total','pending')";
$n = my_iud($query);
if($n==1)
{
echo '<script>alert("Booking SuccessFull");
window.location = "viewbooking.php";
</script>';
}
else
{
echo '<script>alert("Something Went Wrong");
</script>';
}

}




if(isset($_POST["cod"]))
{

$bookingdate=$_POST['bookingdate'];

$customername=$_POST['customername'];

$emailid=$_POST['emailid'];
$contact=$_POST['contactno'];
$city=$_POST['city'];
$address=$_POST['address'];
$productname=$_POST['productname'];
$sprice=$_POST['sprice'];
$quantity=$_POST['quantity'];
$total=$_POST['total'];
$query="insert into booking(bookingdate,customername,email,contact,city,address,productname,price,quantity,total,status) values('$bookingdate','$customername','$emailid','$contact','$city','$address','$productname','$sprice','$quantity','$total','pending')";
$n = my_iud($query);
if($n==1)
{
echo '<script>alert("Booking SuccessFull");
window.location = "viewbooking.php";
</script>';
}
else
{
echo '<script>alert("Something Went Wrong");
</script>';
}
}


?>

