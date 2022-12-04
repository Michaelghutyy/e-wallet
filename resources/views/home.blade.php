@extends('layouts.DashboardLayout')

@push('costum-style')
<style>
	.pagination .disabled{
		margin-right: 10px;
		margin-left: 10px;
	}
	.pagination > li > a{
		color: white;
	}
</style>

@endpush

@section('title', 'Dashboard')

@section('iconPage')
	<i class="mdi mdi-home"></i>

@section('pageTitle', 'Dasboard')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">
	<span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
</li>
@endsection

@section('pageContent')
@if (Auth::user()->roles == 'admin')
	<div class="row" >
		<div class="col-md-4 stretch-card grid-margin">
			<div class="card bg-gradient-info card-img-holder text-white">
				<div class="card-body" style="height: 150px">
					<img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
					<h4 class="font-weight-normal mb-3">Transaction <i class="mdi mdi-login  mdi-22px float-right"></i>
					</h4>
					<h2 class="mb-5">{{ $transaction->count() }}</h2>
				</div>
			</div>
		</div>
		<div class="col-md-4 stretch-card grid-margin">
			<div class="card bg-gradient-danger card-img-holder text-white">
				<div class="card-body" style="height: 150px">
					<img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
					<h4 class="font-weight-normal mb-3">Customer
						<i class="mdi mdi-logout  mdi-22px float-right"></i>
					</h4>
					<h2 class="mb-5">{{ $customer->count() }}</h2>
				</div>
			</div>
		</div>
		<div class="col-md-4 stretch-card grid-margin">
			<div class="card bg-gradient-success card-img-holder text-white">
				<div class="card-body" style="height: 150px">
					<img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
					<h4 class="font-weight-normal mb-3">Users <i class=" mdi mdi-account mdi-22px float-right"></i>
					</h4>
					<h2 class="mb-5">{{ $user->count() }}</h2>
				</div>
			</div>
		</div>
	</div>
@elseif(Auth::user()->roles == 'customer')
<div class="row" >
	<div class="col-md-4 stretch-card grid-margin">
		<div class="card bg-gradient-info card-img-holder text-white">
			<div class="card-body" style="height: 150px">
				<img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
				<h4 class="font-weight-normal mb-3">Total Balance
				<i class=" mdi mdi-account mdi-22px float-right"></i>
				</h4>
				@if($transaction != null)
					<h3 class="mb-5">Rp. {{ number_format($transaction->total,0,',','.') }},-</h2>
				@else
					<h3 class="mb-5">Rp. 0 ,-</h2>
				@endif
			</div>
		</div>
	</div>
	
	<div class="col-md-4 stretch-card grid-margin">
		<div class="card bg-gradient-danger card-img-holder text-white">
			<div class="card-body" style="height: 150px">
				<img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
				<h4 class="font-weight-normal mb-3">Total Deposit
					<i class="mdi mdi-login  mdi-22px float-right"></i>
				</h4>
				<h2 class="mb-5">{{ $deposit->count() }}</h2>
			</div>
		</div>
		</div>
	<div class="col-md-4 stretch-card grid-margin">
		<div class="card bg-gradient-success card-img-holder text-white">
			<div class="card-body" style="height: 150px">
				<img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
				<h4 class="font-weight-normal mb-3">Total Withdraw 
					<i class="mdi mdi-login  mdi-22px float-right"></i>
				</h4>
				<h2 class="mb-5">{{ $withdraw->count() }}</h2>
			</div>
		</div>
	</div>
</div>
@endif

@if (Auth::user()->roles == "customer" || Auth::user()->roles == "admin")
<div class="row">
	<div class="col-lg-6 grid-margin stretch-card">
	  <div class="card">
		<div class="card-body">
		  <h4 class="card-title">Balance Status</h4>
		  <canvas id="areaChart" style="height:250px"></canvas>
		</div>
	  </div>
	</div>
	<div class="col-lg-6 grid-margin stretch-card">
		<div class="card">
		  <div class="card-body">
			<h4 class="card-title">{{ Auth::user()->roles == 'costumer' ? 'Total Transaction' : 'Status' }}</h4>
			<canvas id="doughnutChart" style="height:250px"></canvas>
		  </div>
		</div>
	</div>
</div>
@endif
@endsection

@push('customJs')
	<script>
	  
	  var deposit =  {{ Js::from($deposit->count()) }};
	  var withdraw =  {{ Js::from($withdraw->count()) }};
	  var customer = {{ Js::from($customer->count()) }}
	  var user = {{ Js::from($user->count()) }}
	  var labels =  {{ Js::from($days) }};
	  var balance =  {{ Js::from($balance) }};
	  var roles = {{ Js::from(Auth::user()->roles) }};
	
	  if(roles == 'customer'){
		var label = 'Balance';
		var label2 = ['Deposit', 'Withdraw'];
		var data2 = [deposit, withdraw];
	  }else{
		var label = 'Total Transaction'
		var label2 = ['Deposit', 'Withdraw', 'Costumer', 'User']
		var data2 = [deposit, withdraw, customer, user];
	  }
	  balanceChart(labels, balance, label);
	  doughnutChart(label2, data2);

	function balanceChart(labels, balance, label){
		const dataTransaction = {
			labels: labels,	
			datasets: [{
			  label: label,
			  backgroundColor: [
				'rgba(255, 99, 132, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(255, 206, 86, 0.2)',
				'rgba(75, 192, 192, 0.2)',
				'rgba(153, 102, 255, 0.2)',
				'rgba(255, 159, 64, 0.2)'
			],
		  borderColor: [
				'rgba(255,99,132,1)',
				'rgba(54, 162, 235, 1)',
				'rgba(255, 206, 86, 1)',
				'rgba(75, 192, 192, 1)',
				'rgba(153, 102, 255, 1)',
				'rgba(255, 159, 64, 1)'
			],
			  data: balance,
			}]
		  };
	
		  const config = {
			type: 'line',
			data: dataTransaction,
			options: {}
		  };
	
		  const AreaChart = new Chart(
			document.getElementById('areaChart'),
			config
		  );
	}

	function doughnutChart(label2, data2){
		const dataDoughnut = {
			labels: label2,
			datasets: [{
			  label: 'Doughnut',
			  backgroundColor: [
				'rgba(255, 99, 132, 0.5)',
				'rgba(54, 162, 235, 0.5)',
				'rgba(255, 206, 86, 0.5)',
				'rgba(153, 102, 255, 0.5)',
				'rgba(255, 159, 64, 0.5)',
				'rgba(75, 192, 192, 0.5)',
			],
			borderColor: [
				'rgba(255,99,132,1)',
				'rgba(54, 162, 235, 1)',
				'rgba(255, 206, 86, 1)',
				'rgba(153, 102, 255, 1)',
				'rgba(255, 159, 64, 1)',
				'rgba(75, 192, 192, 1)',
			],
			  data: data2
			}]
		  };
	
		  var doughnutPieOptions = {
			responsive: true,
			animation: {
			  animateScale: true,
			  animateRotate: true
			}
		  };

		  const config2 = {
			type: 'doughnut',
			data: dataDoughnut,
			options: doughnutPieOptions
		  };
	
		  const DoughnutChart = new Chart(
			document.getElementById('doughnutChart'),
			config2
		  );
	}
	</script>
@endpush
