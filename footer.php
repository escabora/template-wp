<footer class="footer">
	<div class="footer__content">
		<div class="container">
			<?php
		      if(is_active_sidebar('footer-sidebar-1')){
		        dynamic_sidebar('footer-sidebar-1');
		       }
		      if(is_active_sidebar('footer-sidebar-2')){
		        dynamic_sidebar('footer-sidebar-2');
		      }
		      if(is_active_sidebar('footer-sidebar-3')){
		        dynamic_sidebar('footer-sidebar-3');
		       }
		     ?>
		</div>
	</div>
	<div class="copyright">
		<div class="container">
			<p>Copyright Name | Todos os direitos reservados</p>	
		</div>
	</div>
</footer>
<?php wp_footer(); ?>

<?php echo get_field('geral_antes_fechar_body_html', 'option'); ?>

</body>
</html>