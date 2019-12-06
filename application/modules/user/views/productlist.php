<div class="profile_area">
       <div class="produclist_src_area"><!--start pro search area-->
        	<div class="pro_src_rht">
            	<input name="" type="text" class="pro_search" /><input name="" type="button" value="Search" class="pro_search_btn " />
            </div>
        </div><!--end search area-->
        
      	<div class="prof_rht_inner margin-top10">
       
        
        <div class="clear"></div>
        	<h2>My product List </h2>
            
             <div class="prolist_main">
             	<div class="prolost_hdr">
                	<ul>
                    <li>Product Name</li>
                     <li>Company Name</li>
                      <li>Model/Batch No</li>
                       <li>NAFDAC No</li>
                        <li>Manufacture Date</li>
                        <li class="last">Expire Date</li>
                    
                    </ul>
                </div>
                <?php
                foreach ($all_data as $key => $val) {
				?>
                <div class="prolost_list">
                	<ul>
                    <li><?= ucwords($val['name']) ?></li>
                     <li><?= ucwords($val['company']) ?></li>
                      <li><?= $val['model_no'] ?></li>
                       <li><?= $val['nafdac_no'] ?></li>
                        <li><?= $val['manufacture_date'] ?></li>
                        <li class="last"><?= $val['expire_date'] ?></li>
                    
                    </ul>
                </div>
                <?php }?>
                  <!--<div class="prolost_list">
                	<ul>
                    <li>Plasma TV</li>
                     <li>Samsung</li>
                      <li>BATV34562314</li>
                       <li>BATV34562314</li>
                        <li>10/21/2013</li>
                        <li class="last">12/31/2018</li>
                    
                    </ul>
                </div>
                  <div class="prolost_list">
                	<ul>
                    <li>Plasma TV</li>
                     <li>Samsung</li>
                      <li>BATV34562314</li>
                       <li>BATV34562314</li>
                        <li>10/21/2013</li>
                        <li class="last">12/31/2018</li>
                    
                    </ul>
                </div>
                  <div class="prolost_list">
                	<ul>
                    <li>Plasma TV</li>
                     <li>Samsung</li>
                      <li>BATV34562314</li>
                       <li>BATV34562314</li>
                        <li>10/21/2013</li>
                        <li class="last">12/31/2018</li>
                    
                    </ul>
                </div>-->
                
              
                
            </div>
            
              <!--<div class="produclist_src_area">
              	<div class="pagenation_div">
                	<a href="#">1</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#">4</a>
                </div>
              </div>-->
            
        </div>
        
      </div>
        
    </section>
    
   
  
  
 
  

</div>
<div class="clear"></div>