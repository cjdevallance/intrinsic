<?php
/*
* Footer template: Intrinsic Yacht & Ship
*/
?>

<?php wp_footer(); ?>

<footer id="footer">

	<div class="footer-inner">

		<div class="footer-logo">
			<img src="<?php bloginfo( 'template_url' ); ?>/images/footer-logo.jpg" alt="Intrinsic Yacht & Ship">
		</div>

		<div class="footer-locations">
			<p>357 Pier One Rd., Suite 101<br>
			Stevensville, MD 21666, USA</p>

			<p class="footer-contact">Toll-free 877-393-9030<br>
			Tel 410-263-9288</p>
            
            <p class="footer-contact-mobile"><a href="tel:18773939030">Toll-free 877-393-9030</a><br>
			<a href="tel:14102639288">Tel 410-263-9288</a></p>
		</div>

		<div class="footer-socialmedia">
			<a href="https://www.facebook.com/intrinsicyacht" target="new"><img src="<?php bloginfo( 'template_url' ); ?>/images/footer-icon-facebook.png" alt="Facebook"></a> 
			<a href="https://twitter.com/intrinsicyacht" target="new"><img src="<?php bloginfo( 'template_url' ); ?>/images/footer-icon-twitter.png" alt="Twitter"></a> 
			<a href="http://www.pinterest.com/intrinsicyacht/" target="new"><img src="<?php bloginfo( 'template_url' ); ?>/images/footer-icon-pinterest.png" alt="Pinterest"> 
			<a href="https://plus.google.com/104826645143181814842/about" target="new"><img src="<?php bloginfo( 'template_url' ); ?>/images/footer-icon-google+.png" alt="Google +"></a>
			<a href="http://instagram.com/INTRINSIC_YACHT" target="new"><img src="<?php bloginfo( 'template_url' ); ?>/images/footer-icon-instagram.png" alt="Instagram"></a>
            <!--youtube: http://www.youtube.com/user/IntrinsicYachts-->
		</div>

		<div class="footer-copyright">
			<p>© 2014 - <? echo date("Y"); ?> Intrinsic Yacht & Ship<br>
			Site by <a href="http://www.dominionmarinemedia.com/websites/portfolio/" target="new">Dominion Marine Media</a></p>
		</div>

	</div> 

<script>
$("#mobile-menu-toggle").click(function () {
$(".navigation-mobile-container").slideToggle();
});

</script>

</footer>

</div>

</body>
</html>