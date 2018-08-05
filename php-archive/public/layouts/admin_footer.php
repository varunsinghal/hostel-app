</div>
    <div id="footer">Powered By DWD-DTU, Copyright <?php echo date("Y", time()); ?></div>
  </body>
</html>
<?php if(isset($database)) { $database->close_connection(); } ?>