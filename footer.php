</main>
<footer class="m-footer">
	<div class="m-footer__content">
		<div class="m-container">
			<?php
			if (is_active_sidebar('footer-sidebar-1')) {
				dynamic_sidebar('footer-sidebar-1');
			}
			if (is_active_sidebar('footer-sidebar-2')) {
				dynamic_sidebar('footer-sidebar-2');
			}
			if (is_active_sidebar('footer-sidebar-3')) {
				dynamic_sidebar('footer-sidebar-3');
			}
			?>
		</div>
	</div>
	<div class="m-copyright">
		<div class="m-container">
			<p>Copyright Name | Todos os direitos reservados</p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>

<?php get_template_part('templates/partials/template', 'loader'); ?>

<?php
$customBeforeCloseBody = get_field('geral_antes_fechar_body_html', 'option');
if ($customBeforeCloseBody) {
	echo $customBeforeCloseBody;
};
?>

<script>
	
	window.TEMPLATEWP = window.TEMPLATEWP || {};
	TEMPLATEWP.adminAjax = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
	TEMPLATEWP.security = "<?php echo wp_create_nonce("load_more_posts"); ?>";
	TEMPLATEWP.pathname = window.location.pathname;

	document.addEventListener('DOMContentLoaded', function() {
		setTimeout(() => {
			document.querySelector('body').classList.remove('has--loader');
		}, 1300);
  	});
    
</script>

</body>

</html>