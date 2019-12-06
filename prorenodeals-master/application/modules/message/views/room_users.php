<?php foreach($members as $mem) {?>
<div class="conversation_loop">


<div class="col-sm-3 col-xs-12 pad0">

<figure class="profile-imgEc pull-left">
<img src="<?php echo ASSETS.'/uploaded/'.$mem['logo']?>" style="height: 50px;width: 50px;border-radius:100%;">
<div class="online-sign"></div>

</figure>
</div>


<div class="col-sm-9 col-xs-12">
<?php echo $mem['fname'].' '.$mem['lname']?><br>
<?php if($mem['userid']==$user){ echo 'owner';}else{ echo 'member';}?>
</div>
</div>
<?php }?>
<input type="hidden" name="hiddenroom" id="hiddenroom" value="<?php echo $roomid?>">