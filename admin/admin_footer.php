</main> <!-- end #admin_data -->
<footer id="admin_footer">
  <p>Copyright&copy; <?php echo date('Y'); echo " ".SITE_OWNER; ?>&nbsp;|&nbsp;<a href="<?php echo SITE_URL; ?>">public site</a></p>
</footer>
<script type="text/javascript" src="<?php echo SITE_URL; ?>/admin/js/actions.js"></script>
</body>
</html>
<?php if(isset($database)) {$database->close_connection();} ?>