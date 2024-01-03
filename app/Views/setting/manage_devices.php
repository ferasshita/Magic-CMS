<div class="row">
			<div class="col-12">
				<div class="box">
					<div class="box-header with-border">
						<h4 class="box-title">devices</h4>
					</div>
					<div class="box-body">
						<div class="table-responsive">

							<table id="refresh" class="reports_1 table table-lg invoice-archive">
								<thead>
								<tr>
									<th>#</th>
									<th>device name</th>
									<th>address</th>
									<th class="text-center"><span class="fa fa-cog"></span></th>
								</tr>
								</thead>
								<tbody>

								<?php
								$serial=0;
								foreach($fetchdivice as $rows) { $serial += 1;
									$ip = $rows['ip'];
									$id = $rows['id'];
									$api_url = "http://ip-api.com/json/$ip";
									$ip_info = json_decode(file_get_contents($api_url));
									?>
									<tr>
									<td>
										<a><p><?php echo $serial; ?>
									</td>
									<td>
										<p><?php echo $ip; ?></p>
									</td>
									<td>
										<p><?php
											if($ip_info->status == 'success'){
												$country = $ip_info->country;
												$city = $ip_info->city;
												echo "$city, $country";
											} else {
												echo "Unable to get IP information";
											}
											 ?></p>
									</td>
									<td><a onclick="block('<?php echo $id; ?>')" class="btn btn-primary"><?php if($rows['status']=="1"){echo"unblock";}else{echo"block";} ?></a></td>
									</tr><?php } ?>

								</tbody>
							</table>

						</div>
					</div>
				</div>
			</div>
		</div>
<script>
	function block(id){

		$.ajax({
			type:'POST',
			url:'<?php echo base_url(); ?>setting/block_ip',
			data:{'id':id},
			beforeSend: function(){
			},
			success: function(done){
				$("#refresh").load(location.href + " #refresh");
			}
		});
	}
</script>
