<section class="sec minH">
<div class="container">  
<?php echo $breadcrumb;?>    
<div class="accordion" id="accordionExample">

	<?php foreach($faq_question_parent  as $key=> $val){?>

    <div class="card mb-0">
    <div class="card-header">
        <h4 class="card-title">
        	<a href="javascript:void(0)" class="collapsed" data-toggle="collapse" data-target="#collapse_<?php echo $key;?>"><?=$val['name']?> <i class="icon-feather-plus-square float-right"></i></a>
        </h4>
    </div>                         
        
    <div id="collapse_<?php echo $key;?>" class="collapse" data-parent="#accordionExample">
    	<div class="card-body">
        <p><?php foreach($val['sub_title']  as $key=> $show){?>
    
        <h4 class="qstn"><?=$show['faq_question']?></h4>
    
        <div class="ans"><?php echo html_entity_decode($show['faq_answers']);?></div>
    
        <?php }?>
      </div>
      </div>
    
    </div>

          <?php }?>

        </div>

  </div>

</section>

<style>
.ans ul, .ans li, .ans ol {
	list-style:inside disc
}
</style>
<script>
$(document).ready(function(){
$('.collapse').on('shown.bs.collapse', function(){
$(this).parent().find(".icon-feather-plus-square").removeClass("icon-feather-plus-square").addClass("icon-feather-minus-square");
}).on('hidden.bs.collapse', function(){
$(this).parent().find(".icon-feather-minus-square").removeClass("icon-feather-minus-square").addClass("icon-feather-plus-square");
});
});
</script>