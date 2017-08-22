<link rel="stylesheet" type="text/css" href="library/css/contact.css">
<script type="text/javascript" src="library/js/jquery.js"></script>
<script type="text/javascript" src="library/js/form.js"></script>

<div id="form">
    <form id="contact-main-form" name="contact" method="post" action="library/contact-submit.php" onSubmit="return checkform()">
        <!--ERROR/SUCCESS MESSAGE-->
        <div id="error"></div>
        <div id="success">Thank you, your email has been sent.</div>
        <!--NAME-->
        <span>Full Name:</span>
        <input type="text" name="name" id="name">
        <!--EMAIL-->
        <span>Email Address:</span>
        <input type="email" name="email" id="email">
        <!--TELEPHONE-->
        <span>Telephone Number:</span>
        <input type="tel" name="phone" id="phone">
		<!--MESSAGE-->
        <span>Message:</span>
        <textarea class="message" name="message" id="message"></textarea>

        <!--VERIFICATION AREA-->
        <span>Enter the code in the box below:</span>
        <div class="verification">
            <img id ="vimage" src="library/captcha.php" alt="Verification code" width="99" />
            <a class="refresh" href="#" onclick="document.getElementById('vimage').src = 'library/captcha.php?' + Math.random(); return false">
                <img src="library/images/refresh.png" alt="Anti Spam">
            </a>
            <!--VERIFICATION INPUT-->
            <input type="text" name="verify" class="text" id="verify" placeholder="Enter the key" title="This confirms you are a human user and not a bot."/>
            <button type='submit' class="button" id='send_message'>Send</button>
        </div>
    </form>
</div>
               
