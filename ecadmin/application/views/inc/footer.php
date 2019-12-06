 </div><!-- End .main  -->
<div class="clearfix"></div>
 <footer>
 <div class="container">
<?php $siteTitle=$this->auto_model->getFeild('site_title','setting','id',1); ?>
        <p>Powered By <?php echo $siteTitle; ?></p>
</div>        
</footer>
<script src="<?= JS ?>lightbox.min.js"></script>
<script src="<?= JS ?>popper.min.js"></script>
<script src="<?= JS ?>bootstrap.min.js"></script>

</body>

</html>