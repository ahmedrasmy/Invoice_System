@extends('layouts.master')
@section('title')
	المنتجات
@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
						</div>
					</div>
					
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif
				{{-- Message flash for  adding section  --}}
				@if (session()->has('Add'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>{{ session()->get('Add') }}</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				@endif

				{{-- Message flash for  editing section  --}}
				@if (session()->has('edit'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>{{ session()->get('edit') }}</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				@endif

				@if (session()->has('delete'))
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>{{ session()->get('delete') }}</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				@endif
				<!-- row -->
				<div class="row">
					<div class="col-sm-6 col-md-4 col-xl-2 mb-3">
						<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#exampleModal"> إضافة منتج</a>
					</div>
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-body">
								<div class="table-responsive">
									<table id="example1" class="table key-buttons text-md-nowrap" data-page-length="50">
										<thead>
											<tr>
												<th class="border-bottom-0">#</th>
												<th class="border-bottom-0">اسم المنتج</th>
												<th class="border-bottom-0">اسم القسم</th>
												<th class="border-bottom-0"> ملاحظات</th>
												<th class="border-bottom-0">العمليات</th>
												
											</tr>
										</thead>
										<tbody>
											<?php $i=0 ?>
											@foreach ($products as $product)
											<?php $i++ ?>
												<tr>
													<td>{{$i}}</td>
													<td>{{$product ->Product_name}}</td>
													<td>{{$product->section->section_name}}</td>
													<td>{{$product ->description}}</td>
													<td>
														{{-- Button for editing product  --}}
															<a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
																data-id="{{ $product->id }}" data-Product_name="{{ $product->Product_name }}"
																data-description="{{ $product->description }}" data-toggle="modal"
																href="#exampleModal2" title="تعديل"><i class="las la-pen"></i></a>
														
				
														{{-- Button for deleting product  --}}
															<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
																data-id="{{ $product->id }}" data-Product_name="{{ $product->Product_name }}"
																 data-toggle="modal"
																href="#modaldemo9" title="حذف"><i class="las la-trash"></i></a>														
													</td>
													
												</tr>
											@endforeach
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

				</div>
				<!-- row closed -->
			{{-- Start Add Product  --}}
				<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
				aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">اضافة منتج</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="{{ route('products.store') }}" method="post">
							{{ csrf_field() }}
							<div class="modal-body">
								<div class="form-group">
									<label for="exampleInputEmail1">اسم المنتج</label>
									<input type="text" class="form-control" id="Product_name" name="Product_name" >
								</div>
	
								<label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
								<select name="section_id" id="section_id" class="form-control" >
									<option value="" selected disabled> --حدد القسم--</option>
									@foreach ($sections as $section)
										<option value="{{ $section->id }}">{{ $section->section_name }}</option>
									@endforeach
								</select>
	
								<div class="form-group">
									<label for="exampleFormControlTextarea1">ملاحظات</label>
									<textarea class="form-control" id="description" name="description" rows="3"></textarea>
								</div>
	
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-success">تاكيد</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			{{-- End Add Product  --}}
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
@endsection