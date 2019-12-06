<div class="form-group">
    <label class="col-lg-2 control-label" for="required">Select Position</label>
    <div class="col-lg-3">
        <select name="pos" for="required"  class="select select_type required  form-control">
            <?php foreach ($positions as $key => $pos) { 
                ?>
                <option value="<? echo $pos['position_id']; ?>"><? echo $pos['position_val']; ?></option>
            <? } ?>
        </select>	
    </div>
</div>
