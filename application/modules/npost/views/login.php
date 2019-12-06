 <!-- Content Start -->
         <div id="main">
             <?php echo $breadcrumb;?>
    <script type="text/javascript">
	function loginFormPost(){
	FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>login/check",'register');
    }
	</script>      
	<script src="<?=JS?>mycustom.js"></script>	
           <!-- Main Content start-->
            <div class="content">
               <div class="container">
                      <div class="row">
                     <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12" id="contact-form" style="width:100%;">
                       <h3 class="title">Login</h3>
                                       <div class="loginright"><img src="<?php echo VPATH;?>assets/images/loginbg_img.png" alt=""  title=""/></div>
                      
						<div class="success alert-success alert" style="display:none">Your message has been sent successfully.</div>
                        <?php
                        if($this->session->flashdata('log_eror'))
						{
						?>
                        <div class="success alert-success alert"><?php echo $this->session->flashdata('log_eror');?></div>
                        <?php
                        }
						?>
						
						<?php
							$attributes = array('id' => 'register','class' => 'reply','role'=>'form','name'=>'register','onsubmit'=>"disable");
							echo form_open('', $attributes);
								  ?>
                     <span id="agree_termsError" class="rerror error alert-error alert" style="display:none"></span>
						
                        <div class="divider"></div>
                           <fieldset>
                              
							 
                              <div class="row">
							  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>UserName/Email: <span>*</span></label>
                                    <input class="form-control" id="username" name="username" type="text" value="<?php echo set_value('username');?>" required>
									<span id="usernameError" class="rerror"></span>
                                </div>
                               
                                 
                              </div>
							   <div class="row">
							 
                                 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Password: <span>*</span></label>
                                    <input class="form-control" id="password" name="password" type="password" value="" required>
									<span id="passwordError" class="rerror"></span>
                                 </div>
                                 
                              </div>
							  
                           </fieldset>
                           <input class="btn-normal btn-color submit  bottom-pad" type="button" id="submit-check" onclick="loginFormPost()" value="Login" />  
                           
                           
                           <div class="clearfix">
                           </div>
                        </form>
                     </div>
                     <!--<div class="col-lg-4 col-md-4 col-xs-12 col-sm-6">
                        <div class="address widget">
                           <h3 class="title">Head Office</h3>
                           <ul class="contact-us">
                              <li>
                                 <i class="icon-map-marker"></i>
                                 <p>
                                    <strong>Address:</strong> 250 Sher-E- Bangla Road, <br>
                                    Khulna, Bangladesh
                                 </p>
                              </li>
                              <li>
                                 <i class="icon-phone"></i>
                                 <p>
                                    <strong>Phone:</strong> +880 41 723 272
                                 </p>
                              </li>
                              <li>
                                 <i class="icon-envelope"></i>
                                 <p>
                                    <strong>Email:</strong><a href="mailto:info@fifothemes.com">info@fifothemes.com</a>
                                 </p>
                              </li>
                           </ul>
                        </div>
                        <div class="contact-info widget">
                           <h3 class="title">Business Hour</h3>
                           <ul>
                              <li><i class="icon-time"> </i>Monday - Friday 9am to 5pm </li>
                              <li><i class="icon-time"> </i>Saturday - 9am to 2pm</li>
                              <li><i class="icon-remove-circle"> </i>Sunday - Closed</li>
                           </ul>
                        </div>
                        <div class="follow widget">
                           <h3 class="title">Follow Us</h3>
                           <div class="member-social dark">
                              <a class="facebook" href="#"><i class="icon-facebook"></i></a>
                              <a class="twitter" href="#"><i class="icon-twitter"></i></a>
                              <a class="dribbble" href="#"><i class="icon-dribbble"></i></a>
                              <a class="gplus" href="#"><i class="icon-google-plus"></i></a>
                              <a class="linkedin" href="#"><i class="icon-linkedin"></i></a>
                           </div>
                        </div>
                     </div>-->
                  </div>
               </div>
            </div>
            <!-- Main Content end-->
           
			
            <!-- Our Clients Start-->
            
         </div>
         <!-- Content End -->