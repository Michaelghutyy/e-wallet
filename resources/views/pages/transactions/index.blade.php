@extends('layouts.DashboardLayout')

@section('title', 'Transaction')

@section('iconPage')
<i class="mdi mdi-table-large menu-icon"></i>
@endsection

@section('pageTitle', 'Transaction')

@section('breadcrumb')
	<li class="breadcrumb-item active" aria-current="page">
		<span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
	</li>
@endsection

@section('pageContent')
@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
	{{ $message }}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@elseif ($error = Session::get('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	{{ $error }}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

	<div class="row">
		<div class="col-12 grid-margin strecth-card">

			<div class="delete-response">

			</div>

			<div class="card">
				<div class="card-body">
					<div class="d-flex justify-content-between mb-3">
						<h4 class="card-title">Data Transaction</h4>
						@if (Auth::user()->roles == 'admin')
							<a href="{{ route('transaction.create') }}" class="btn btn-gradient-primary btn-rounded btn-fw"><div class="mdi mdi-plus">Tambah Data</div></a>
						@endif
					</div>
					<div class="row">
						<div class="col-md-3">
							@if (Auth::user()->roles == 'admin')
							<div class="form-group">
								<label for="user_id">Filter By User</label>
								<select name="user_id" id="user_id" class="form-select m-0" style="font-size: 0.8125rem; padding:15.04px 22px; border:1px solid #ebedf2;">
									<option value="">Select User</option>
									@foreach ($dataUser as $user)
									<option value="{{ $user->id }}">{{ $user->name }}</option>
									@endforeach
								</select>
							</div>
							@elseif (Auth::user()->roles == 'customer')
							<div class="form-group">
								<label for="user_id">User</label>
								<select name="user_id" id="user_id" class="form-select m-0" style="font-size: 0.9125rem; padding:15.04px 22px 15.04px 0px; border:none; background-image:none;">
									<option value="{{ Auth::user()->id }}">COS0{{ Auth::user()->id }} - {{ ucfirst(Auth::user()->name) }}</option>
								</select>
							</div>
							@endif
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="start_date">Start Date</label>
								<input type="datetime-local" name="start_date" id="start_date" class="form-control datepicker-here" data-language="en">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="end_date">End Date</label>
								<input type="datetime-local" name="end_date" id="end_date" class="form-control">
							</div>
						</div>
						<div class="col-md-3 align-self-center d-flex flex-row-reverse">
							<button type="button" name="filter" id="filter" class="btn btn-danger btn-rounded btn-lg" style="width:180px">
								<i class="mdi mdi-filter-outline"></i>
								Filter
							</button>
						</div>
					</div>

					<table class="table table-striped table-bordered dt-responsive nowrap w-100 display" id="tableTransaction">
						<thead>
								<tr>
										<th width="70px">No</th>
										<th>Name</th>
										<th>Amount</th>
										<th>Payment Type</th>
										<th>Total</th>
										<th>Created At</th>
										<th>Status</th>
										@if (Auth::user()->roles == 'admin')
											<th width="150px">Action</th>
										@else
											<th></th>
										@endif
								</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('customJs')
		<script>
			load_data();
			function load_data(start_date = null, end_date = null, user_id = ''){
				var datatable = $('#tableTransaction').DataTable({
					processing: true,
					serverSide: true,
					ordering: true,
					buttons: [
						{
							extend: 'excel',
							text: 'Save current page',
							exportOptions: {
								modifier: {
									page: 'current'
								}
							}
						}
					],
					ajax: {
						url : '{!! url()->current() !!}',
						type : 'GET', 
						data : {
							start_date: start_date,
							end_date: end_date,
							user_id : user_id
						}
					},
					order: [
						[5, 'desc']
					],
					columns: [{
							data: 'DT_RowIndex',
							name: 'DT_RowIndex',
							width: '1%',
							orderable: false,
							searchable: false
						},
						{
							data: 'user.name',
							name: 'name'
						},
						{
							data: 'amount',
							name: 'amount'
						},
						{
							data: 'type',
							name: 'type'
						},
						{
							data: 'total',
							name: 'total'
						},
						{
							data: 'created_at',
							name: 'created_at',
						},
						{
							data: 'status',
							name: 'status',
						},
						{
							data: 'action',
							name: 'action',
							orderable: false,
							searchable: false,
							width: '1%'
						}
					],
					sDom: '<"secondBar d-flex flex-w1rap justify-content-between mb-2"lf>rt<"bottom"p>',
					"fnCreatedRow": function(nRow, data) {
						$(nRow).attr('id', 'transaction' + data.id);
					},
				});
			}

		$(document).on("click", ".delete-data", function(){
			var id = $(this).data('id');
			var token = $("meta[name='csrf-token']").attr("content");

			$.ajax({
				url:"/transaction/" + id,
				type : "DELETE",
				data : {
					"id" : id,
					"_token" : token,
				},
				success: function(data){
					$('#transaction' + id).remove();
					$('#tableTransaction').DataTable().ajax.reload();
					$('#tableTransaction').DataTable().draw();
					$(".delete-response").append(
							'<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil Menghapus Data<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
					);
				},
				error: function(data){
					console.log('Error', data);
				}
			});
		});


		$(document).on("click", ".update-status", function(){
			var id = $(this).data('id');
			var token = $("meta[name='csrf-token']").attr("content");

			$.ajax({
				url:"/transaction/updateStatus/" + id,
				type : "POST",
				data : {
					"id" : id,
					"_token" : token,
				},
				success: function(data){
					$('#transaction' + id).remove();
					$('#tableTransaction').DataTable().ajax.reload();
					$('#tableTransaction').DataTable().draw();
					$(".delete-response").append(
							'<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil Mengupdate Status<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
					);
				},
				error: function(data){
					console.log('Error', data);
				}
			});
		});

		$('#filter').click(function(){
			var start_date = $('#start_date').val();
			var end_date = $('#end_date').val();
			var user_id = $('#user_id').val();
			if(start_date != '' && end_date != '' || user_id != ''){
				$('#tableTransaction').DataTable().destroy();
				load_data(start_date, end_date, user_id);
			}
		});		
		</script>
@endpush