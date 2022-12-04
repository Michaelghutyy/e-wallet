@extends('layouts.DashboardLayout')

@section('title', 'Costumer')

@section('iconPage')
<i class="mdi mdi-table-large menu-icon"></i>
@endsection

@section('pageTitle', 'Costumer')

@section('breadcrumb')
	<li class="breadcrumb-item active" aria-current="page">
		<span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
	</li>
@endsection

@section('pageContent')
@if ($message = Session::get('message'))
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
					<div class="d-flex justify-content-between mb-5">
						<h4 class="card-title">Data Costumer</h4>
						<a href="{{ route('costumer.create') }}" class="btn btn-gradient-primary btn-rounded btn-fw"><div class="mdi mdi-plus">Tambah Data</div></a>
					</div>

					<table class="table table-striped table-bordered dt-responsive nowrap w-100 display" id="tableUser">
						<thead>
								<tr>
										<th width="70px">No</th>
										<th>Nama</th>
										<th>Email</th>
										<th>Created At</th>
										<th width="150px">Action</th>
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
			var datatable = $('#tableUser').DataTable({
			processing: true,
			serverSide: true,
			ordering: true,
			ajax: '{!! url()->current() !!}',
			order: [
				[1, 'asc']
			],
			columns: [{
					data: 'DT_RowIndex',
					name: 'DT_RowIndex',
					width: '1%',
					orderable: false,
					searchable: false
				},
				{
					data: 'name',
					name: 'name'
				},
				{
					data: 'email',
					name: 'email'
				},
				{
					data: 'created_at',
					name: 'created_at',
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
				$(nRow).attr('id', 'user' + data.id);
			},
		});


		$(document).on("click", ".delete-data", function(){
			var id = $(this).data('id');
			var token = $("meta[name='csrf-token']").attr("content");

			$.ajax({
				url:"/users/" + id,
				type : "DELETE",
				data : {
					"id" : id,
					"_token" : token,
				},
				success: function(data){
					$('#user' + id).remove();
					$('#tableUser').DataTable().ajax.reload();
					$('#tableUser').DataTable().draw();
					$(".delete-response").append(
							'<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil Menghapus Data<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
					);
				},
				error: function(data){
					console.log('Error', data);
				}
			});
		});
		</script>
@endpush