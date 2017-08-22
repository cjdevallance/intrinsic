<style>

span#bravo
		{display: none;}

input.criticalinformation
		{display: none;}

</style>

<?php
$int0 = rand(1,9);
$int1 = rand(1,9);
$int2 = rand(1,9);
$sum = $int1 + $int2;
?>



			<?php 
			if ($_GET['sent']){
			echo "<p>THANK YOU!</p>

			<p>Your inquiry has been sent successfully and a member of our team will be in contact as soon as possible.</p>";
			} else { ?>

			<?php $reference = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
 ?>
			
            <form id="contact-main-form" name="contact_us_desktop" method="post" action="<?php bloginfo( 'template_url' ); ?>/contact-form.php">
			<input class="starfish" type="text" name="starfish">
            <input type="hidden" name="reference" value="<?php echo $reference; ?>">


            <div class="contact-form-field">
                Full Name<span class="required-star">*</span>:<br>
                <input type="text" name="name">				
            </div>

            <div class="contact-form-field">
                Telephone:<br>
                <input type="text" name="phone">
            </div>

            <div class="contact-form-field">				
                Email Address<span class="required-star">*</span>:<br>
                <input type="text" name="email">
            </div>

            <div class="contact-form-field">
                Subject:<br>
                <input type="text" name="subject" value="<?php echo stripslashes($noslashsubj); ?>">
            </div>

            <div class="contact-form-field">
                Your question or message:<br>
                <textarea name="comments" style="height: 65px;" cols="20"></textarea>
            </div>

            <!-- new CAPTCHA
            <div style="width: 97%; min-height: 100px; margin: 5% 0 0; display: inline-block;">
            	<span>Enter the code in the box below:</span>
                <div class="verification">
                    <img id ="vimage" src="<?php bloginfo( 'template_url' ); ?>/captcha-form/library/captcha.php" alt="Verification code" width="99">
                    <a class="refresh" href="#" onclick="document.getElementById('vimage').src = 'http://intrinsicyacht.com/wp-content/themes/intrinsic-custom/captcha-form/library/captcha.php?' + Math.random(); return false">
                    <img src="<?php bloginfo( 'template_url' ); ?>/captcha-form/library/images/refresh.png" alt="Anti Spam">
                    </a>
                  
                    <input type="text" name="verify" class="text" id="verify" placeholder="Enter the code" title="This confirms you are a human user and not a bot.">
				</div>
            </div>
			end new CAPTCHA -->

			<!-- Math CAPTCHA -->
			<div class="contact-form-field">
                Solve: <?php echo "<span id='alpha'>" . $int1 . "</span>" . " + " . "<span id='bravo'>" . $int0  . " + " . "</span>" . "<span id='charlie'>" . $int2  . "</span>" . " = ";?><br>
                <input type="text" name="result">
                <input type="text" name="criticalinfo" class="criticalinformation" value="">
                <input type="hidden" name="check0" value="13">
                <input type="hidden" name="check1" value="5">
                <input type="hidden" name="check2" value="13">
                <input type="hidden" name="check3" value="<?php echo $int1; ?>">
                <input type="hidden" name="check4" value="17">
                <input type="hidden" name="check5" value="<?php echo $int2; ?>">
                <input type="hidden" name="check6" value="10">
                <input type="hidden" name="check7" value="<?php echo $sum; ?>">
                <input type="hidden" name="check8" value="6">
                <input type="hidden" name="check9" value="<?php echo $int0; ?>">
            </div>
            <!-- end Math CAPTCHA -->

            <div class="search-table-button" style="width: 97%; margin: 5% 0 0; display: inline-block;">
            	<a href="javascript:validate_contact_us_desktop();" class="search-form-button" id="send_message">Submit</a>
			</div>

            <p class="required-text"><span class="required-star">*</span> required field</p>
            
            </form>
        
			<? } ?>
