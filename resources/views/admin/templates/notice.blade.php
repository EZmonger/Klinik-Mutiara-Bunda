@if(session()->has('success'))
<script>
    Swal.fire({
        title: "Sukses",
        text: '{{ session("success") }}',
        timer: 2000,
        showConfirmButton: true,
        type: "success",        
        icon: 'success',
    })
</script>
@endif



@if(session()->has('update'))
<script>
    Swal.fire({
        title: "Sukses",
        text: '{{ session("update") }}',
        timer: 2000,
        showConfirmButton: true,
        type: "success",        
        icon: 'success'         
    })
</script>
@endif

@if(session()->has('delete'))
<script>
    swal.fire({
        text: '{{ session("delete") }}',
        timer: 2000,
        showConfirmButton: true,
    });
</script>
@endif

@if(session()->has('warning'))
<script>   
    Swal.fire({
        title: "Warning",
        text: '{{ session("warning") }}',
        timer: 2000,
        showConfirmButton: false,
        type: "warning",        
        icon: 'warning'         
    })
</script>
@endif

@if(session()->has('notif'))
<script>   
    Swal.fire({        
        text: '{{ session("notif") }}',
        timer: 2000,
        showConfirmButton: false,
        type: "info",                
        icon: 'info'
    })
</script>
@endif

@if(session()->has('error'))
<script>   
    Swal.fire({
        title: "Error",
        text: '{{ session("error") }}',
        timer: 2000,
        showConfirmButton: false,
        type: "error",        
        icon: 'error'         
    })
</script>
@endif

@if(session()->has('fail'))
<script>
    Swal.fire({
  position: 'center',
  icon: 'error',
  title: '{{ session("fail") }}',
  showConfirmButton: true
  })
</script>
@endif


<script>
$(document).on('click', '.btn-delete', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    var url = id;

    Swal.fire({
        title: 'Hapus Data',
        text: "Yakin Ingin Menghapus Data ?",        
        showCancelButton: true,
        confirmButtonColor: '#d9534f',        
        confirmButtonText: 'Hapus',
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: url,                
                type: 'get',
                success: function (data) {
                    Swal.fire(
                        'Dihapus!',
                        'Data Berhasil Dihapus.',                        
                        'success'
                    );
                    location.reload();
                },
                error: function (data) {
                    Swal.fire(
                        'Gagal!',
                        'Data Gagal Dihapus.',
                        'error'
                    );
                }
            });
        }
    })
});
</script>

