
<style>
.la-star, .la-star-o {
	font-size:16px
}
.fix-right {
    position: absolute;
    top: 0px;
    right: 0px;
}

.relative {
    position: relative;
}
</style>
<section id="content">
    <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('contest/list_all')?>">Contest list</a> </li>        
        <li class="breadcrumb-item active"><a>Contest Entries</a></li>
      </ol>
    </nav>         
        <div class="container-fluid">

	<form action="">
    <div class="input-group mb-3">
      <input type="text" class="form-control" name="entry_id" value="<?php echo !empty($srch['entry_id']) ? $srch['entry_id'] : ''; ?>" placeholder="Entry ID" />
	  <input type="text" class="form-control" name="name" value="<?php echo !empty($srch['name']) ? $srch['name'] : ''; ?>" placeholder="Name" />
      <div class="input-group-append">
        <button class="btn btn-primary" type="submit" name='submit' id="submit">Search</button>
      </div>
    </div>
	</form>
				
				
				<div id="walletError"></div>	
				<?php
                    if ($this->session->flashdata('succ_msg')) {
                        ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="la la-check-circle la-2x"></i> Well done!</strong> <?= $this->session->flashdata('succ_msg') ?>
                        </div> 
						
                        <?php
                    }  if ($this->session->flashdata('error_msg')) {  ?>
                        <div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="icon24 i-close-4"></i> Oh snap!</strong> <?= $this->session->flashdata('error_msg') ?>
                        </div>
						<?php } ?>
						
                    <table class="table table-hover adminmenu_list">
                        <thead>
                            <tr>
                                <th>Entry Id</th>
                                <th>User Info</th>
                                <th>Title</th>
                                <th>Sale Price</th>
                                <th>Sealed Entry</th>
                                <th align="right">Action</th>
                            </tr>
                        </thead>
                       <tbody>
                       
                            <?php
                               $attr = array(
                                
                                'class' => 'la la-times _165x red',
                                'title' => 'Delete'
                            );
                            $atr3 = array(
                                
                                'class' => 'la la-check-circle _165x red',
                                'title' => 'Inactive'
                            );
                            $atr4 = array(
                               
                                'class' => 'la la-check-circle _165x green',
                                'title' => 'Active',
								'href'=> 'javascript:;'
                            );
							?>
                            <?php
                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) { 
								
								?>

                                    <tr> 

                                        <td><?php echo !empty($val['entry_id']) ? $val['entry_id'] : '-'; ?></td>
                                        <td>
											<div class="relative">
											<div><b>Full Name: </b><?php echo $val['fname'].' '.$val['lname'];?></div>
											<div>
											<b>Rating: </b>
											<?php 
											for($i=0; $i<5; $i++){
												if($i < $val['user_review']){
													echo '<i class="la la-star"></i> ';
												}else{
													echo '<i class="la la-star-o"></i> ';
												}
											}
											?>
											</div>
											<?php if($val['is_awarded'] == 1){ ?>
											<img class="fix-right" src="<?php echo IMAGE;?>awarded.png" height="40" width="40"/>
											<?php } ?>
											</div>
										</td>
										<td>
											<?php echo !empty($val['title']) ? (strlen($val['title']) > 60 ? substr($val['title'], 0, 60).'...' : $val['title']) : ''; ?>
										</td>
                                        <td>$<?php echo !empty($val['sale_price']) ? $val['sale_price'] : '0.00'; ?></td>
                                        <td><?php echo (!empty($val['is_sealed']) && ($val['is_sealed'] == 1)) ? 'Yes' : 'No'; ?></td>
                                       <td align="right">
									   <div id="contest_entry_<?php echo $val['entry_id']; ?>">
											<?php if(!empty($contest_detail['status']) && ($contest_detail['status'] != 'C') && $contest_detail['is_guranteed'] == 1){ ?>
											
											<button class="btn btn-sm btn-primary awardBtn" onclick="awardContest('<?php echo $val['entry_id']; ?>', '<?php echo $contest_detail['contest_id']?>')">Award</button>
											
											<?php } ?>
											<a href="javascript:void(0);" onclick="entryDetail('<?php echo $val['entry_id']; ?>')" title="View Files"><i class="la la-eye _165x"></i></a>
										</div>
									   </td>
                                        
                                    </tr>

                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7" align="center" style="color:#F00">No records found...</td>
                                </tr>
							
								<?php
							}
							?>
							
						
                        </tbody>
                    </table>
					
					<?php echo $links;?>
					                
        </div>
        <!-- End .container-fluid  -->
    </div>
    <!-- End .wrapper  -->
</section>


<!-- Modal -->
<div class="modal fade" id="entryModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">      
      <div class="modal-body">
		
      </div>
      
    </div>
  </div>
</div>

<script>

function entryDetail(id){
	$('#entryModal').find('.modal-body').html('<p class="text-center">Loading...</p>');
	$('#entryModal').modal('show');
	$.get('<?php echo base_url('contest/entry_detail')?>/'+id, function(res){
		$('#entryModal').find('.modal-body').html(res);
	});
}

function awardContest(entry_id, contest_id){

	if(entry_id == ''){
		return ;
	}
	
	$.ajax({
		url : '<?php echo base_url('contest/award_contest')?>',
		data: {entry_id: entry_id, contest_id: contest_id},
		dataType: 'JSON',
		type: 'POST',
		beforeSend: function(){
			$('#contest_entry_'+entry_id).find('.awardBtn').html('Checking..').attr('disabled', 'disabled');
		},
		success: function(res){
			if(res.status == 1){
				location.reload();
			}else{
				$('#walletError').html(res.errors.wallet);
			}
		}
	});
	
}



</script>
