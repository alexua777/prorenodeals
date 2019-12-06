<style>
#mainnav .list-group{
	height:580px
}
</style>

<aside id="sidebar">    
    <div class="sidebar-wrapper">
        <nav id="mainnav" class="main-menu-content">
            <ul class="nav nav-list list-group">
            
                <li>
                    <a href="<?php echo VPATH; ?>" class="list-group-item">
                        <span class="icon"><i class="la la-dashboard"></i></span>
                        <span class="txt menu-title">Dashboard</span>                        
                    </a>
                </li>
                <li>
                    <a href="#" class="list-group-item">
                        <span class="icon"><i class="la la-user-plus"></i></span>
                        <span class="txt menu-title">Admin menu</span>
                    </a>
                    <ul class="sub menu-content">
                        <li>
                            <a href="<?= VPATH ?>menulist">
                                <i class="la la-arrow-right"></i> Menu list
                            </a>
                        </li>
                        <li>
                            <a href="<?= VPATH ?>addnewmenu">
                                <i class="la la-plus"></i> Add menu
                            </a>
                        </li>

                    </ul>
                </li>
                <?php
                $cur_page = $this->router->fetch_class();
				$sess_var=$this->session->userdata('user');
				/*echo $sess_var->type;*/
				$menu=$this->auto_model->getFeild('menus','adminuser_type','id',$sess_var->type);
				$menu=explode(',',$menu);
                for ($i = 1; $i <= sizeof($data); $i++) {
					if(in_array($data[$i]['id'],$menu))
					{
                    $chlid = $this->auto_model->leftpanelchild($data[$i]['id']);
                    $parent = $this->auto_model->get_current_controller($data[$i]['id']);
                    $style = '';
                    $sub_style = '';
                    if (count($chlid) > 0) {
                        $style = 'class="hasSub"';
                        if ($cur_page!="") {
                            if ($parent['parent_url'] == $cur_page) {
                                $style = 'class="hasSub current"';
                                $sub_style = " expand show";
                            }
                        }
                    }
                    ?>
                    <li <?= $style ?>>
                        <a href="javascript:void(0);" class="list-group-item">
                            <span class="icon"><i class="la la-<?= $data[$i]['style_class'] ?>"></i></span>
                            <span class="txt menu-title"><?php echo $data[$i]['name']; ?></span>
                        </a>
                        <ul class="sub<?= $sub_style ?> menu-content" >
    <?php
    foreach ($chlid as $childmenu) {
        ?>	
                                <li>								
                                    <a href="<?php echo base_url() . $childmenu['url']; ?>">
                                        <i class="la la-arrow-right"></i> <?php echo $childmenu['name']; ?>                                        
                                    </a>
                                </li>
        <?php
    }
    ?>
                        </ul>
                    </li>
                            <?php
					}
                        }
                        ?>

            </ul>
        </nav> <!-- End #mainnav -->
    </div>
    <!-- End .sidebar-wrapper  -->
</aside><!-- End #sidebar  -->
<link href="<?= CSS ?>perfect-scrollbar.css" rel="stylesheet" type="text/css" />
<script src="<?= JS ?>perfect-scrollbar.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
var window_height = $(window).height();

$('#mainnav  ul.nav-list > li > a').on('mouseover', function(e){
	var top_scroll = $(document).scrollTop().valueOf();
	console.log(top_scroll);
	
	var is_collapse = $('#sidebar').is('.isCollapse');
	
	if(is_collapse){
		var pos_y = e.clientY;
		
		var ele_offset_top = $(this).parent().offset().top - top_scroll;
		console.log(ele_offset_top);
		//console.log($(this).offset());
		
		var ele_offset_h = $(this).parent().height();
		
		if(pos_y >= ele_offset_top && pos_y <= (ele_offset_top + ele_offset_h)){
			pos_y = ele_offset_top;
		}
		
		//console.log(pos_y);
		var child = $(this).parent().find('.sub');
		var child_h = child.height();
		var child_title = $(this).parent().find('.menu-title');
		var child_title_height = child_title.height();
		//console.log(child_title);
		child_title.css({
			top: pos_y+'px', 	 	
		});
		child.css({			
			top: pos_y+child_title_height+'px', 	 	
		});
		
	}else{
		child_title.css({
			top: pos_y+'px', 	 	
		});
		child.css({			
			top: pos_y+child_title_height+'px', 	 	
		});
	}
		
});

	var ps = new PerfectScrollbar('#mainnav .list-group');			
});
</script>
