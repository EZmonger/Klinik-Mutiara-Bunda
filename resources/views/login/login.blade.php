<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Klinik Mutiara Bunda | Login</title>
    <link rel="shortcut icon" href="/icon/favicon.ico" type="image/x-icon">
    <link href="/assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">        
    <!-- Custom Theme Style -->
    <link href="/assets/build/css/custom.min.css" rel="stylesheet">
    <script src="/package/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="/package/dist/sweetalert2.min.css">    
</head>
<body>        
    <div class="login_wrapper" style="max-width: 400px;">
        <div class="x_panel login_form">        
            <h2 class="text-center pt-3">SELAMAT DATANG</h2>
            <h2 class="text-center">Klinik Mutiara Bunda</h2>
            <div class="x_content">       
                {{-- FORM LOGINS     --}}
                <form role="form" class="text-start" action="/signin" method="post">
                    @csrf
                    <div class="input-group input-group-outline mt-3">
                        <input type="text" class="form-control" placeholder="Username" id="username" name="username" onkeyup="upperUsername()" value="{{ old('username') }}">
                    </div>                    
                    @error('username')
                        <div><small class="text-danger mb-3">{{ $message }}</small></div>
                    @enderror

                    <div class="input-group input-group-outline mt-3">
                        <input type="password" class="form-control" id="pass" placeholder="Password" name="password">
                        <span class="input-group-text" id="eyebtn" onclick="showpass()">
                            <i class="fa fa-eye-slash"></i>
                        </span>
                    </div>
                    @error('password')
                        <div><small class="text-danger mb-3">{{ $message }}</small></div>
                    @enderror

                    <button type="submit" class="btn btn-primary w-100 my-4 mb-2">Login</button>
                    
                    <div class="clearfix"></div>
    
                    <div class="col-md-12 col-sm-12 pt-4 text-center">
                        {{-- <p>© Copyright 2023.<br>Klinik Mutiara Bunda. All Rights Reserved.</p> --}}
                    </div>
                    </div>
                </form>
                    
            </div>
        </div>
    </div>
</body>
</html>

@if(session()->has('fail'))
<script>
    Swal.fire({
    position: 'center',
    icon: 'error',
    title:  "{{ session('fail') }}",
    showConfirmButton: true,

    });
</script>
@endif

<script>
    function upperUsername() {
        let x = document.getElementById("username");
        x.value = x.value.toLowerCase();
    }
</script>

<script>
    function showpass()
    {
        var x = document.getElementById('pass').type;
        if (x == 'password')
        {
        document.getElementById('pass').type = 'text';
        document.getElementById('eyebtn').innerHTML = '<i class="fa fa-eye"></i>';
        }
        else
        {
            document.getElementById('pass').type = 'password';
            document.getElementById('eyebtn').innerHTML = '<i class="fa fa-eye-slash"></i>';
        }
    }
</script>