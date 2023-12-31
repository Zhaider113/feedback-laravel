<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

        <title>Travel App</title>
    </head>

    <body>
        <div class="container">
            <br><br>
            <div class="row">
                <div class = "col-md-3"></div>
                <div class = "col-md-6 col-12">
                    <div style = "border:1px solid gainsboro; padding:30px; border-radius: 11px; ">
                        <h3 style = "text-align: center;">Travel App</h3>
                        <p style = "text-align: center;">One Liner Tag Line for Travel App</p>
                        <div class = "row">                        
                            <div class = "col-md-12 text-center">
                            @if(session()->has('message'))
                                <div class="alert alert-success text-center">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            @if(session()->has('error'))
                                <div class="alert alert-danger text-center">
                                    {{ session()->get('error') }}
                                </div>
                            @endif
                            </div>                        
                        </div>
                        <form action="{{ route('register-user.store') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" autocomplete = "off" class="form-control" name="name" placeholder="Enter Name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" autocomplete = "off" class="form-control" name="email" placeholder="Enter Enail" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="phone" autocomplete = "off" class="form-control" name="phone" placeholder="Enter Phone" required>
                            </div>
                            <button type="submit" name = "submit" value = "submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>                    
                </div>
                <div class = "col-md-3"></div>
            </div>            
        </div>
    </body>
</html>