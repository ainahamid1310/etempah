 {{-- @extends('layouts.backend_applicant')
    @section('content') --}}
    <div >
      <div >
          <div >
			<h3>How To Create Dependent Drop down in Laravel</h3>
          </div>
          <div >
        <form method="post">
         {{ csrf_field() }}
         <div >
          <div >
           <div >
            <label for="roll">Dept <span >*</span></label>
            {{-- <select name="name_dept"  id="name_dept">
             <option value="">-- Select Dept --</option>
             @foreach ($departments as $department)
             <option value="{{ $department->id }}">{{ ucfirst($department->nama) }}</option>
             @endforeach
            </select> --}}
         </div>
          </div>
          <div >
           <div >
            <label for="roll">Section </label>
             <select name="name_dept"  id="name_dept">
             <option value="">-- Select Dept --</option>
             @foreach ($departments as $department)
             <option value="{{ $department->id }}">{{ ucfirst($department->nama) }}</option>
             @endforeach
            </select>
            {{-- <select name="name_section" id="name_section">
            </select> --}}
            </div>
          </div>
         </div>

         <div >
           <div >
            <label for="roll">Level </label>
            {{-- <select name="name_level" id="name_level">
            </select> --}}
            </div>
          </div>
         </div>


       </form>

          </div>
        </div>
    </div>

    {{-- @endsection --}}


    {{-- @section('script') --}}
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    {{-- <script type="text/javascript" src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script> --}}

    {{-- <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">

    <script>
            $(document).ready(function() {
            $('#name_dept').on('change', function() {
                var getStId = $(this).val();
                if(getStId) {
                    alert(getStId);
                    $.ajax({
                        url: '/searchSection/'+getStId,
                        type: "GET",
                        data : {"_token":"{{ csrf_token() }}"},
                        dataType: "json",
                        success:function(data)
                        {

                            if(data)
                            {

                            $('#name_section').empty();
                            $('#name_section').focus;
                            $('#name_section').append('<option value="">-- Select Section --</option>');


                            $.each(data, function(key, value){
                                if(value.nama != '' || value.nama != NULL || value.nama)){
                                    $('select[name="name_section"]').append('<option value="'+ key +'">' + value.nama+ '</option>');
                                }else{
                                    alert('level');
                                }
                            });


                        }else{

                        $('#name_section').empty();
                        }
                        }
                    });
                }else{
                    $('#name_section').empty();
                }
            });
        });
        </script>
