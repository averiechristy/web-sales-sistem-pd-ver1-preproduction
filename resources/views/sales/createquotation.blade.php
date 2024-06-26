@extends('layouts.sales.app')
@section('content')
<div class="container">                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                       Quotation
                                    </div>
                                    <div class="card-body">
            <form name="saveform" action="{{route('sales.simpanquotation')}}" method="post" onsubmit="return validateForm()">
                        @csrf                                                        
<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Tanggal Order</label>
    <input name="quote_date" id="quote_date" type="date" class="form-control" style="border-color: #01004C; width:50%;" value="" />
</div>

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Tanggal Valid</label>
    <input name="valid_date" id="valid_date" type="date" class="form-control" style="border-color: #01004C; width:50%;" value="" />
</div>

<script>
    // Mendapatkan elemen input tanggal
    var validDateInput = document.getElementById('valid_date');

    // Mendapatkan tanggal hari ini
    var today = new Date();

    // Menambah 30 hari ke tanggal hari ini
    var validDate = new Date(today);
    validDate.setDate(validDate.getDate() + 30);

    // Format tanggal menjadi YYYY-MM-DD untuk input tanggal
    var formattedValidDate = validDate.toISOString().substr(0, 10);

    // Mengatur nilai input tanggal valid ke 30 hari dari hari ini
    validDateInput.value = formattedValidDate;
</script>


<script>
    // Mendapatkan elemen input tanggal
    var so_date_input = document.getElementById("valid_date");

    // Mendapatkan tanggal hari ini
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;

    // Set nilai minimum input tanggal ke hari ini
    so_date_input.min = today;
</script>

<script>
    // Mendapatkan elemen input tanggal
    var orderDateInput = document.getElementById('quote_date');

    // Mendapatkan tanggal hari ini
    var today = new Date();

    // Format tanggal hari ini menjadi YYYY-MM-DD untuk input tanggal
    var formattedDate = today.toISOString().substr(0, 10);

    // Mengatur nilai input tanggal ke tanggal hari ini
    orderDateInput.value = formattedDate;
</script>

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Customer</label>
    <select name="customer_id" id="customerSelect" class="form-control customer-select" style="border-color: #01004C; max-width: 100%;" aria-label=".form-select-lg example">
        <option value="" selected disabled>-- Pilih Customer --</option>
        @foreach ($customer as $item)
        <option value="{{$item->id}}" data-nama="{{$item->nama_customer}}" data-alamat="{{$item->lokasi}}" data-pic="{{$item->nama_pic}}">{{$item->nama_customer}}</option>
        @endforeach
    </select>
</div>


<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;" hidden>Nama Customer</label>
    <input hidden name="nama_customer" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Alamat</label>
    <textarea name="alamat" class="form-control" style="border-color: #01004C;" rows="4" ></textarea>
</div>

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;" >Nama PIC</label>
    <input  name="nama_penerima" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<script>
    $(document).ready(function() {
        $('#customerSelect').select2();
    });

    $(document).ready(function() {
    $('#customerSelect').change(function() {
        var selectedOption = $(this).find('option:selected');
        var namaCustomer = selectedOption.data('nama');
        var alamatCustomer = selectedOption.data('alamat');
        var namaPIC = selectedOption.data('pic');

        $('input[name="nama_customer"]').val(namaCustomer);
        $('textarea[name="alamat"]').val(alamatCustomer);
        $('input[name="nama_penerima"]').val(namaPIC);
        
    });
});

</script>

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Tanggal Pengiriman</label>
    <input name="shipping_date" id="shipping_date"  type="date" class="form-control" style="border-color: #01004C; width:50%;" value="" />
</div>

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Tanggal Pembayaran</label>
    <input name="payment_date" id="payment_date" type="date" class="form-control" style="border-color: #01004C; width:50%;" value="" />
</div>



<!-- Product and Quantity Fields -->
<div id="product-fields">
    <div class="row product-field">
        <div class="col-md-6">
            <div class="form-group mb-4">
                <label for="" class="form-label" style="color:black;">Produk</label>
                <select name="product[]" class="form-control product-select" style="border-color: #01004C;max-width: 100%;" aria-label=".form-select-lg example">
                    <option value="" selected disabled>-- Pilih Produk --</option>
                    @foreach ($produk as $item)
            <option value="{{$item->id}}">{{$item->kode_produk}} - {{$item->nama_produk}}</option>
        @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group mb-4">
                <label for="" class="form-label" style="color:black;">Quantity</label>
                <input name="quantity[]" type="number" class="form-control" style="border-color: #01004C;" value=""  oninput="validasiNumber(this)"/>
            </div>
        </div>
        <div class="col-md-1">
        <label for="" class="form-label" style="color:black;">Action</label>
            <button type="button" class="btn btn-sm btn-danger remove-product-field mt-1">Remove</button>
        </div>
    </div>
</div>
<button type="button" class="btn btn-success mt-3" id="add-product-field">Add Product</button>

<!-- JavaScript for Dynamically Adding/Removing Product Fields -->
<script>
    $(document).ready(function() {
        // Add Product Field
        $("#add-product-field").click(function() {
            var productField = `
                <div class="row product-field">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="" class="form-label" style="color:black;">Produk</label>
                            <select name="product[]" class="form-control product-select" style="border-color: #01004C;max-width: 100%;" aria-label=".form-select-lg example">
                                <option value="" selected disabled>-- Pilih Produk --</option>
                                @foreach ($produk as $item)
            <option value="{{$item->id}}">{{$item->kode_produk}} - {{$item->nama_produk}}</option>
        @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group mb-4">
                            <label for="" class="form-label" style="color:black;">Quantity</label>
                            <input name="quantity[]" type="number" class="form-control" style="border-color: #01004C;" value=""  oninput="validasiNumber(this)"/>
                        </div>
                    </div>
                    <div class="col-md-1">
                    <label for="" class="form-label" style="color:black;">Action</label>
                        <button type="button" class="btn btn-sm btn-danger remove-product-field mt-1">Remove</button>
                    </div>
                </div>`;
            $("#product-fields").append(productField);
            $(".product-select").select2(); // Initialize Select2 for new Product Select
        });

        // Remove Product Field
        $(document).on("click", ".remove-product-field", function() {
            $(this).closest(".product-field").remove();
        });

        // Initialize Select2 for Product Select
        $(".product-select").select2();
    });
</script>



<div class="form-group mb-4 mt-4">
<label for="" class="form-label" style="color:black;">Opsi Discount</label>
<br>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="discpersen" value="persen">
                              <label class="form-check-label"  style="margin-left: 5px;" for="inlineRadio1">Discount dalam %</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="discrp" value="amount">
                              <label class="form-check-label"  style="margin-left: 5px;" for="inlineRadio2">Discount dalam Rp</label>
                            </div>
</div>

<div class="form-group mb-4 mt-3">
        <label for="" class="form-label" style="color:black;">Discount</label>
    <input name="discount" type="number"  class="form-control " style="border-color: #01004C;" value=""  oninput="validasiNumber(this)"/>
</div>

<div class="form-group mb-4 mt-3">
        <label for="" class="form-label" style="color:black;">PPN (dalam %)</label>
    <input name="ppn" type="number"  class="form-control " style="border-color: #01004C;" value="" oninput="validasiNumber(this)" />
</div>


<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Catatan</label>
    <select name="catatan_id" id="catatan_id" class="form-control" style="border-color: #01004C;" aria-label=".form-select-lg example" >
        <option value="" selected disabled>-- Pilih Catatan --</option>
        @foreach ($catatan as $data)
            <option value="{{$data->id}}" data-isi_catatan="{{$data->isi_catatan}}"> {{$data->judul_catatan}}</option>
        @endforeach
    </select>
</div>       

<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Isi Catatan</label>
  <textarea class="form-control" name="isi_catatan" id="isi_catatan" rows="5" disabled></textarea>
</div>


<script>
$(document).ready(function() {
    $('#catatan_id').change(function() {
        var selectedOption = $(this).find('option:selected');
        var isi = selectedOption.data('isi_catatan');
        $('textarea[name="isi_catatan"]').val(isi);
        $('textarea[name="isi_catatan"]').prop('disabled', false);
    });
});
</script>

<div class="form-group mb-4 mt-3">
<button type="button" class="btn btn-pd" onclick="confirmSubmit()" >Proses Quotation</button>
</div>
                                            </div>

                                              <!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Quotation</h5>
            </div>
            <div class="modal-body">
                Apakah Anda yakin akan memproses data? Silakan cek kembali sebelum proses data
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="submit" class="btn btn-primary" id="confirmButton">Ya</button>
            </div>
        </div>
    </div>
</div>

<script>
function validasiNumber(input) {
    // Hapus karakter titik (.) dari nilai input
    input.value = input.value.replace(/\./g, '');

    // Pastikan hanya karakter angka yang diterima
    input.value = input.value.replace(/\D/g, '');
}
</script>

<script>
    function confirmSubmit() {
        // Panggil fungsi untuk melakukan validasi form
        if (validateForm()) {
            // Jika validasi berhasil, tampilkan modal
            $('#confirmModal').modal('show');
        }
        // Mengembalikan false untuk mencegah pengiriman form secara langsung
        return false;
    }

    // Fungsi untuk menutup modal
    $('#confirmModal').on('hide.bs.modal', function () {
        // Mengatur nilai modalOpened menjadi false
        modalOpened = false;
    });

    // Fungsi untuk menangani klik tombol "Tidak"
    $('#confirmModal button[data-bs-dismiss="modal"]').on('click', function() {
        // Menutup modal ketika tombol "Tidak" ditekan
        $('#confirmModal').modal('hide');
    });
</script>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
    
            <script>
    function validateForm() {
        var validdate = document.forms["saveform"]["valid_date"].value;

        if (validdate == "") {
            alert("Tanggal valid harus dipilih");
            closeModal();
            return false;
        }

        var customerId = document.forms["saveform"]["customer_id"].value;

        // Validasi Customer ID
        if (customerId == "") {
            alert("Customer harus dipilih");
            closeModal();
            return false;
        }

        var alamat = document.forms["saveform"]["alamat"].value;
        if (alamat == "") {
            alert("Alamat harus diisi");
            closeModal();
            return false;
        }

        var namapenerima = document.forms["saveform"]["nama_penerima"].value;

        if (namapenerima == "") {
            alert("Nama PIC harus diisi");
            closeModal();
            return false;
        }
        // Mendapatkan nilai dari input Tanggal Order
   // Mendapatkan nilai dari input Tanggal Order
var orderDate = document.forms["saveform"]["quote_date"].value;

// Mendapatkan nilai dari input Tanggal Pengiriman
var shippingDate = document.forms["saveform"]["shipping_date"].value;

// Mendapatkan nilai dari input Tanggal Pembayaran
var paymentDate = document.forms["saveform"]["payment_date"].value;

        // Validasi Tanggal Order
        if (orderDate == "") {
            alert("Tanggal Order harus diisi");
            closeModal();
            return false;
        }

        // Validasi Tanggal Pengiriman
        if (shippingDate == "") {
            alert("Tanggal Pengiriman harus diisi");
            closeModal();
            return false;
        }

        // Validasi Tanggal Pembayaran
        if (paymentDate == "") {
            alert("Tanggal Pembayaran harus diisi");
            closeModal();
            return false;
        }

        if(shippingDate < paymentDate) {
            alert("Tanggal pengiriman tidak boleh kurang dari tanggal pembayaran");
            closeModal();
            return false;
        }

        var products = document.getElementsByName('product[]');
        var quantities = document.getElementsByName('quantity[]');
        var isValidProduct = false;
        var selectedProducts = [];
        for (var i = 0; i < products.length; i++) {
            if (products[i].value != "") {
                isValidProduct = true;
                // Validasi jumlah produk
                if (quantities[i].value == "") {
                    alert("Harap isi jumlah untuk setiap produk yang dipilih");
                    closeModal();
                    return false;
                }

                if (selectedProducts.includes(products[i].value)) {
                alert("Produk yang sama tidak boleh dipilih lebih dari satu kali.");
                closeModal();
                return false;
            } else {
                selectedProducts.push(products[i].value);
            }
            }
        }
        if (!isValidProduct) {
            alert("Minimal satu produk harus dipilih");
            closeModal();
            return false;
        }
        // Validasi radiobutton
        var radioValue = document.querySelector('input[name="inlineRadioOptions"]:checked');
        if (!radioValue) {
            alert("Harap pilih salah satu opsi diskon");
            closeModal();
            return false;
        }

        // Validasi discount
        var discount = document.forms["saveform"]["discount"].value;
        if (discount == "") {
            alert("Discount harus diisi");
            closeModal();
            return false;
        }

        // Validasi PPN
        var ppn = document.forms["saveform"]["ppn"].value;
        if (ppn == "") {
            alert("PPN harus diisi");
            closeModal();
            return false;
        }

        var catatan = document.forms["saveform"]["catatan_id"].value;

// Validasi Customer ID
if (catatan == "") {
    alert("Catatan harus dipilih");
    closeModal();
    return false;
}     
        return true;
    }
    
    function closeModal() {
        // Tutup modal secara manual
        $('#confirmModal').modal('hide');
    }

</script>

<script>
window.onload = function () {
    var inputFields = document.getElementsByTagName('input');
    for (var i = 0; i < inputFields.length; i++) {
        if (inputFields[i].type !== 'date' && inputFields[i].name !== '_token' && inputFields[i].type !== 'radio') {
            inputFields[i].value = '';
        }
    }

    var textareaFields = document.getElementsByTagName('textarea');
    for (var j = 0; j < textareaFields.length; j++) {
        textareaFields[j].value = '';
    }

    var selectFields = document.getElementsByTagName('select');
    for (var k = 0; k < selectFields.length; k++) {
        selectFields[k].selectedIndex = 0; // Mengatur indeks pilihan ke 0
    }
        
    if (window.history && window.history.pushState) {
        window.addEventListener('popstate', function () {
            window.location.reload();
        });
    }
};

</script>

@endsection