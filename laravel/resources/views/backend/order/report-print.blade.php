<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('template/web/plugins/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/web/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">

    <style media="screen">
    @media print {
        .btn {
            display:none;
        }
    }
    </style>

  </head>
  <body>

      <div class="loading">

      </div>

	  <?php $site = DB::table('cms_config')->first(); ?>

    <header>
        <div class="container" style="text0align:center;margin-bottom:50px;margin-top:50px;">
            <img src="{{ asset($site->logo) }}" alt="{{ $site->site_name }}" class="img-responsive" style="margin:auto;">
        </div>
    </header>

    <main>
        <div class="container">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Invoice ID</th>
                      <th>Order Date</th>
                      <th>Member Name</th>
                      <th>Member Email</th>
                      <th>Total</th>
                    </tr>
                  </thead>

                  <tbody>
                    @foreach($order as $data)
                      <tr>
                        <td data-label="#">#{{$data->order_id}}</td>

                        <td data-label="Order Date">{{$data->order_date}}</td>
                        <td data-label="Member">{{$data->member_fullname}}</td>
                        <td data-label="Payment Status">
                            {{$data->member_email}}
                        </td>
                        <td data-label="Total"><span class="price_format"> <?= number_format($data->order_total,0,'.',','); ?></span></td>

                      </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer>
        <div class="container" style="text-align:right;margin-bottom:50px;">
            <button type="button" class="btn btn-success" name="button" onclick="printpage()" id="printpagebutton">Print</button>
        </div>
    </footer>


    <script type="text/javascript" src="{{ asset('template/web/plugins/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template/web/plugins/bootstrap-3.3.7-dist/js/bootstrap.min.js') }}"></script>

    <script type="text/javascript">
        function printpage() {
            var printButton = document.getElementById("printpagebutton");
            printButton.style.visibility = 'hidden';
            window.print()
            printButton.style.visibility = 'visible';
        }
    </script>

  </body>
</html>
