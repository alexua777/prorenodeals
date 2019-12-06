
<table class="table table-hover table-bordered adminmenu_list">
	<thead>  	
		<tr>
			<th>Txn Row ID #</th>
			<th>Datetime</th>
			<th>Owner</th>
			<th>Info</th>
			<th>Debit&nbsp;(Dr)</th>
			<th>Credit&nbsp;(Cr)</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		if(count($txn_detail) > 0){ foreach($txn_detail as $k => $v){  
		$wallet_detail = $this->db->where('wallet_id', $v['wallet_id'])->get('wallet')->row_array();
		?>
		<tr>
			<td><?php echo !empty($v['txn_row_id']) ? $v['txn_row_id'] : '';?></td>
			<td><?php echo !empty($v['datetime']) ? $v['datetime'] : '';?></td>
			<td>
				<?php echo !empty($wallet_detail['title']) ? $wallet_detail['title'] :'No Name'; ?>
			</td>
			<td><?php echo !empty($v['info']) ? $v['info'] : '';?></td>
			<td><?php echo !empty($v['debit']) ? $v['debit'] : '0.00';?></td>
			<td><?php echo !empty($v['credit']) ? $v['credit'] : '0.00';?></td>
		</tr>
		<?php } } ?>
	</tbody>
</table>