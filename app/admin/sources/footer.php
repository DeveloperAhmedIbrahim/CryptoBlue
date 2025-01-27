
<?php
if(!defined('CryptExchanger_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}
?>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Design & Developed By <a href="https://ranawebdesign.com/" target="_blank">Rana WebDesign</a></span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted  & made with <i class="ti-heart text-danger ml-1"></i></span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="./assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="./assets/vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="./assets/js/off-canvas.js"></script>
  <script src="./assets/js/hoverable-collapse.js"></script>
  <script src="./assets/js/template.js"></script>
  <script src="./assets/js/settings.js"></script>
  <script src="./assets/js/todolist.js"></script>
  <script src="./assets/vendors/tinymce/tinymce.min.js"></script>
  <script src="./assets/vendors/tinymce/themes/modern/theme.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="./assets/js/dashboard.js"></script>
  <script src="./assets/js/editorDemo.js"></script>
  
	<script src="./assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  <script src="./assets/js/ceadmin.js"></script>
  <script src="./assets/js/tooltips.js"></script>
  <script src="./assets/js/popover.js"></script>

  
<script>
  function manage_wallets(action,currency,gateway_id)
  {
    var amount = $("#"+currency+"-amount").val();
    jQuery.ajax({
        url:'./requests/ajax.php',
        method:"POST",
        data:{
          amount:amount,
          gateway_id:gateway_id,
          type:"manage_wallets",
          action:action,
        },
        success:function(response)
        {
          window.location.href = window.location.href;
        }
    });
  }
</script>
  <!-- End custom js for this page-->
</body>

</html>

