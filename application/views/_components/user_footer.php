			</div>
	    </div>

	    <?php if( $this->session->userdata( 'user' ) ): ?>
		<footer>
	        <hr>
	        <p>&copy; 2013 <a href="<?=base_url()?>">Intellicar E-Performance</a></p>
	    </footer>
	    <?php endif; ?>

	    <script src="<?=base_url().JS?>bootstrap.js"></script>

	</body>
</html>
