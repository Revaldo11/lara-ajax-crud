<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ajax CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
  </head>
  <body>
    <div class="container mt-4">
        <h1>Student List</h1>
        <a href="javascript:void(0)" class="btn btn-success mb-2" id="add_student" style="float:right;">Tambah Data</a>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="modelHeading"></h4>
          </div>
          <div class="modal-body">
            <form id="studentForm" name="studentForm" class="form-horizontal">
              @csrf
               <input type="hidden" name="student_id" id="student_id">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Nama</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama" value="" maxlength="50" required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-12">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" value="" required="">
                    </div>
                </div>
                <div class="col-sm-offset-2 col-sm-10 mt-3">
                  <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                  </button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script>
        $(function () {
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

          var table = $('.data-table').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('students.index') }}",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {data: 'name', name: 'name'},
                  {data: 'email', name: 'email'},
                  {data: 'action', name: 'action'},
              ]
          });

          $('#add_student').click(function () {
              $('#saveBtn').val("create-student");
              $('#student_id').val('');
              $('#studentForm').trigger("reset");
              $('#modelHeading').html("Tambah Data");
              $('#ajaxModel').modal('show');
          });

          $('#saveBtn').click(function(data){
            data.preventDefault();
            $(this).html('Save');

            $.ajax({
              data:$("#studentForm").serialize(),
              url:"{{route('students.store')}}",
              type:"post",
              dataType:'json',
              success:function(data){
                $('#studentForm').trigger("reset");
                $('#ajaxModel').modal('show');
                table.draw();
              },
              error:function(data){
                console.log('Error', data);
                $("saveBtn").html('Save');
              }
            });
          });

          $('body').on('click','.deleteStudent', function(){
            var student_id = $(this).data("id");
            confirm("Anda Yakin Ingin Menghapus Data ini!")
            $.ajax({
              methods: "DELETE",
              type:"DELETE",
              dataType:'json',
              url:"{{route('students.store')}}"+'/'+student_id,
              success:function(data){
                table.draw();
              },
              error:function(data){
                console.log('Error', data);
              }
            });
          });
        });
    </script>
  </body>
</html>