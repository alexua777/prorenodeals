
<section class="breadcrumb-classic">  
  <div class="container">
    <div class="row">
    <aside class="col-sm-6 col-xs-12">
		<h3>Contact Us</h3>
    </aside>
    <aside class="col-sm-6 col-xs-12">
        <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
      <li class="breadcrumb-item active">Contact</li>
    </ol>
    </aside>            
    </div>
	</div>       
</section>
<section class="sec">
  <div class="container">
    <div class="row">
    <aside class="col-md-8 col-sm-6 col-xs-12">
    	<h4 class="title-sm">Send Us an Email</h4>
        <div class="whiteSec" id="contact-form">
        
        <p>Feel free to talk to our online representative at any time you please using our Live Chat system on our website or one of the below instant messaging programs.</p>
        <p>Please be patient while waiting for response. (24/7 Support!) </p>
        <div class="spacer-15"></div>
          <?php if($this->session->flashdata('succ_msg')){

        ?>
          <div class="success alert-success alert"><?php echo $this->session->flashdata('succ_msg');?></div>
          <?php

         }elseif($this->session->flashdata('error_msg')){

         

            echo $this->session->flashdata('error_msg');

         

         }?>
        <div class="clearfix"></div>
        <form method="post" class="form-horizontal"  action="<?php echo base_url()?>contact/contact_form" id="contact" name="contact">
          <fieldset>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Name: <span>*</span></label>
                <input class="form-control" id="name" name="name" type="text" value="<?php echo set_value('name'); ?>" tooltiptext="Enter Your Name" />
                <?php echo form_error('name', '<div class="error-msg5">', '</div>'); ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Email: <span>*</span></label>
                <input class="form-control" type="email" id="email" name="email" value="<?php echo set_value('email'); ?>" tooltipText="Enter Your Valid Email Id" />
                <?php echo form_error('email', '<div class="error-msg5">', '</div>'); ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Subject: <span>*</span></label>
                <input class="form-control" id="subject" name="subject" type="text" value="<?php echo set_value('subject'); ?>" tooltipText="Enter Your Subject" />
                <?php echo form_error('subject', '<div class="error-msg5">', '</div>'); ?> </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Message: <span>*</span></label>
                <textarea class="form-control" id="text" name="message" rows="3" cols="40" tooltipText="Enter Your Message" />
                <?php echo set_value('message'); ?>
                </textarea>
                <?php echo form_error('message', '<div class="error-msg5">', '</div>'); ?> </div>
            </div>
          </fieldset>
          <button class="btn btn-site" type="submit" name="contact" value="contact">Submit</button>
          <div class="success alert-success alert" style="display:none">Your message has been sent successfully.</div>
          <div class="error alert-error alert" style="display:none">E-mail must be valid and message must be longer than 100 characters.</div>
          <div class="clearfix"> </div>
        </form>
      </div>
    </aside>
    <aside class="col-md-4 col-sm-6 col-xs-12">
    <h4 class="title-sm">Head Office</h4>
      <div class="whiteSec">
        <div class="address">          
          <ul class="contact-us">
            <li> <i class="fa fa-map-marker"></i>
              <p> <strong>Address:</strong> <?php echo $address;?> </p>
            </li>
            <li> <i class="fa fa-phone"></i>
              <p> <strong>Phone:</strong> <?php echo $contact_no;?> </p>
            </li>
            <li> <i class="fa fa-envelope"></i>
              <p> <strong>Email:</strong> <a href="mailto:<?php echo $email;?>"> <?php echo $email;?> </a> </p>
            </li>
          </ul>
        </div>      
        <div class="spacer-10"></div>  
        <!--<div class="contact-info widget">
           <h3 class="title">Business Hour</h3>
           <ul>
              <li><i class="icon-time"> </i>Monday - Friday 9am to 5pm </li>
              <li><i class="icon-time"> </i>Saturday - 9am to 2pm</li>
              <li><i class="icon-remove-circle"> </i>Sunday - Closed</li>
           </ul>
        </div>-->    
           
        <?php

        $popular=$this->auto_model->getalldata('','popular','id','1');

        ?>
        <div class="follow">
          <h4 class="title-sm">Follow Us</h4>
          <ul class="social-icons icons-A icon-circle">
            <?php

    foreach($popular as $vals)

    {

    ?>
            <?php

            if($vals->facebook=='Y' && ADMIN_FACEBOOK!='')

            {

            ?>
            <li><a href="<?php echo ADMIN_FACEBOOK;?>" target="_blank"><i class="zmdi zmdi-facebook"></i></a></li>
            <?php }?>
            <?php

                if($vals->twitter=='Y' && ADMIN_TWITTER!='')

                {

                ?>
            <li><a class="twitter" href="<?php echo ADMIN_TWITTER;?>" target="_blank"><i class="zmdi zmdi-twitter"></i></a></li>
            <?php }?>
            <?php

                if($vals->pinterest=='Y' && ADMIN_PINTEREST!='')

                {

                ?>
            <li><a class="dribbble" href="<?php echo ADMIN_PINTEREST;?>" target="_blank"><i class="zmdi zmdi-dribbble"></i></a></li>
            <?php }?>
            <?php

                if($vals->rss=='Y' && ADMIN_RSS!='')

                {

                ?>
            <li><a class="rss" href="<?php echo ADMIN_RSS;?>" target="_blank"><i class="zmdi zmdi-rss"></i></a></li>
            <?php }?>
            <?php

                if($vals->linkedin=='Y' && ADMIN_LINKEDIN!='')

                {

                ?>
            <li><a class="linkedin" href="<?php echo ADMIN_LINKEDIN;?>" target="_blank"><i class="zmdi zmdi-linkedin"></i></a></li>
            <?php }?>
            <?php
			}
    

              ?>
          </ul>
        </div>
      </div>
    </aside> 
    </div>
    <div class="spacer-20"></div>
    
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h4 class="title-sm">Our Location</h4>
        <div id="maps" class="google-maps"> <?php echo html_entity_decode($contact[0]['map']);?> </div>
                
      </div>
    </div>
    
  </div>
</section>
<div class="clearfix"></div>
<?php 

  

  if(isset($ad_page)){ 

    $type=$this->auto_model->getFeild("type","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));

  if($type=='A') 

  {

   $code=$this->auto_model->getFeild("advertise_code","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 

  }

  else

  {

   $image=$this->auto_model->getFeild("banner_image","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));

    $url=$this->auto_model->getFeild("banner_url","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 

  }

        

      if($type=='A'&& $code!=""){ 

?>
<div class="addbox2">
  <?php 

   echo $code;

 ?>
</div>
<?php                      

      }

   elseif($type=='B'&& $image!="")

   {

  ?>
<div class="addbox2"> <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a> </div>
<?php  

 }

  }

?>
<div class="clearfix"></div>
