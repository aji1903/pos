<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ $title ?? '' }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
    @include('sweetalert::alert')

    @include('layouts.inc.header')
    @include('layouts.inc.sidebar')
    @include('layouts.inc.footer')




    <main id="main" class="main">


        <div class="pagetitle">
            <h1>@yield('title')</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Pages</li>
                    <li class="breadcrumb-item active">Blank</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        @yield('content')



    </main><!-- End #main -->



    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <script>
        // Jquery #category_id, document.getElementById('category_id')
        // javascript document.querySelector('#id')
        // JQuery
        $('#category_id').change(function() {
            let cat_id = $(this).val(),
                option = `<option value=''>Select One</option>`;
            $.ajax({
                url: '/get-product/' + cat_id,
                type: 'GET',
                dataType: 'json',
                success: function(resp) {
                    // console.log("response", resp);
                    $.each(resp.data, function(index, value) {
                        option +=
                            `<option value='${value.id}' data-price="${value.product_price}" data-img="${value.product_photo}">${value.product_name}</option>`;
                        // $('#product_id').html("<option value='" + value.id + "'>" + value
                        //     .product_name +
                        //     "</option>")

                    });
                    console.log(option)

                    $('#product_id').html(option);
                }
            });

        });

        function formatRupiah(number) {
            const formatted = number.toLocaleString("id", {
                minimunFractionDigits: 0,
                maximumFractionDigits: 0,
            });
            return formatted;
        }
        $('.add-row').click(function() {
            let tbody = $('tbody');
            let selectedOption = $('#product_id').find('option:selected');
            let namaProduk = selectedOption.text();
            let productId = selectedOption.val();
            let photoProduct = selectedOption.data('img');
            let productPrice = parseInt(selectedOption.data('price')) || 0;


            if ($('#category_id').val() == '') {
                alert('category required');
                return false;
            }
            if ($('#product_id').val() == '') {
                alert('product required');
                return false;
            }
            let newRow = `<tr class='remove-row'>`;
            newRow +=
                `<td><img src='{{ asset('storage/') }}/${photoProduct}' width='60' alt='ini' ></td>`
            newRow += `<td>${namaProduk}<input type='hidden' name='product_id[]'value='${productId}'>  </td>`
            newRow +=
                `<td width='110px'><input type='number' value='1' class='qty form-control' name='qty[]'></td>`
            newRow +=
                `<td><input type='hidden' name='order_price[]'value='${productPrice}'><span class='price' data-price=${productPrice}></span>RP ${formatRupiah(productPrice)}</td>`
            newRow +=
                `<td><input class='subtotal_input'type='hidden' name='order_subtotal[]'value='${productPrice}'>RP <span class='subtotal'>${formatRupiah(productPrice)}</span></td>`
            newRow += `<td><button type='button' class='btn btn-danger btn-sm removeBtn'>Remove</button></td>`
            newRow += `</tr>`;

            tbody.append(newRow);
            // calculateSubTotal;
            clearAll();

            $('.qty').on('input', function() {
                let row = $(this).closest('tr');
                let qty = parseInt($(this).val()) || 0;
                let price = parseInt(row.find('.price').data('price')) || 0;
                let total = qty * price;
                row.find('.subtotal').text(formatRupiah(total));
                row.find('.subtotal_input').val(total);

                calculateSubTotal();

            })
            // calculateSubTotal();
        });

        function calculateSubTotal() {
            let grandtotal = 0;
            $('.subtotal').each(function() {
                let total = parseInt($(this).text().replace(/\./g, ''));
                grandtotal += total;
                // console.log("total", total);
            });
            // console.log(grandtotal);

            $('.grandtotal').text(formatRupiah(grandtotal));
            $('input[name="grandtotal"]').val(grandtotal);

        }


        function clearAll() {
            $('#category_id').val('');
            $('#product_id').val('');

        }



        $('.select2').ready(function() {
            $('.js-example-basic-multiple').select2();
        });

        $('.remove-row').on('click', '.removeBtn', function() {
            let rowToRemove = $(this).closest('tr');
            rowToRemove.remove();
            console.log(rowToRemove);
        })
    </script>

    {{--  dibawah ini contoh sweetalert menggunakan cdn  --}}
    <!-- SweetAlert2 CDN -->
    {{--  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil BROOO!',
        text: '{{ session('success') }}',
    });
</script>
@endif

@if (session('update'))
<script>
    Swal.fire({
        icon: 'update',
        title: 'Berhasil BROOO!',
        text: '{{ session('update') }}',
    });
</script>
@endif  --}}
</body>

</html>
