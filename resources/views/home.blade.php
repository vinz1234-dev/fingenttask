@extends('header')
@section('content')
<div class="col-md-12">
        <p class="text-muted font-weight-normal f-16">Upload Employees: (.csv) </p>
        <div class="d-flex">
        <form id="fa_upload_form">
            <div class="input-group image-preview">
                <input type="text" class="form-control image-preview-filename" disabled="disabled">
                <span class="input-group-btn">

                    <div class="btn btn-default">
                        <span class="glyphicon glyphicon-folder-open"></span>
                        <span class="image-preview-input-title"><i class="zmdi zmdi-plus"></i></span>
                    
                            <input type="file" accept=".csv" name="fa_upload_file" id="fa_upload_file"/>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
 
                    </div>
                </span>
                      
                
            </div>
            <div class="d-flex">
                                <input type="number" class="form-control" name="emp_code"  placeholder="Col of Emp Code">
                                <input type="number" class="form-control" name="emp_name" style="margin-left:20px" placeholder="Col of Emp Name">
                                <input type="number" class="form-control" name="dept" style="margin-left:20px" placeholder="Col of Dept">
                                <input type="number" class="form-control" name="dob" style="margin-left:20px" placeholder="Col of DOB">
                                <input type="number" class="form-control" name="joining_date" style="margin-left:20px" placeholder="Col of JoinDate">
                            </div> 
        </form>
        <button class="btn btn-danger  my-2 px-4 ml-4 fa_upload_button">UPLOAD</button>
</div>  
      
   
</div>
<table class="table" style="margin-top:20px" >
  <thead>
    <tr>
      <th scope="col">Employee Code</th>
      <th scope="col">Employee Name</th>
      <th scope="col">Age</th>
      <th scope="col">Department</th>
      <th scope="col">Experience</th>
    </tr>
  </thead>
  <tbody>
    @foreach($employees as $employee)
        <tr>
            <td scope="col">{{$employee->employee_code}}</td>
            <td scope="col">{{$employee->name}}</td>
            <td scope="col">{{date_diff(date_create($employee->dob), date_create(date('Y-m-d')))->y}}</td>
            <td scope="col">{{$employee->department_name}}</td>
            <td scope="col">{{date_diff(date_create($employee->joining_date), date_create(date('Y-m-d')))->y}}</td>
        </tr>						
    @endforeach
  </tbody>
</table>
@endsection
@section('script')


<script type="text/javascript" language="javascript" src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script>
    $("body").on("change","#fa_upload_file",function(){
	    $('.image-preview-filename').val($('#fa_upload_file').val());
	});

    $("body").on("click",".fa_upload_button",function(){
	    var form = $('#fa_upload_form')[0];
	    var data = new FormData(form);

	    $.ajax({
	        type: "POST",
	        enctype: 'multipart/form-data',
	        url: "{{ route('employee/excel/upload') }}",
	        data: data,
	        processData: false,
	        contentType: false,
	        cache: false,
	        timeout: 600000,
	        success: function (result) {
                
                    alert(result.message);
                    $("#fa_upload_file").val("");
                    $(".image-preview-filename").val("");
                    location.reload();
	        }
	    });
	});	
 

</script>
@endsection