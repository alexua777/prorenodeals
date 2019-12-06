<!-- Main Content start-->

<?php echo $breadcrumb;?>

<section class="sec">
<div class="container">      
<div class="accordion" id="accordionExample">

      <?php foreach($faq_question_parent  as $key=> $val){?>

	<div class="card">
    <div class="card-header">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_<?php echo $key;?>">
          <?=$val['name']?>
        </button>
    </div> 

    <div id="collapse_<?php echo $key;?>" class="collapse" data-parent="#accordionExample">
    <div class="card-body">
    
          <?php foreach($val['sub_title']  as $key=> $show){?>
    
          <div class="qstn"><?=$show['title']?></div>
    
          <div class="ans"><?php echo html_entity_decode($show['content']);?></div>
    
          <?php }?>            
    
    </div>
    </div>
    </div>
    <?php }?>

</div>
</div>
</section>



<!-- Main Content end--> 

