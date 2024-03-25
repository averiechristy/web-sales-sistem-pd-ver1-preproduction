@extends('layouts.superadmin.app')

@section('content')


                <!-- Begin Page Content -->
                <div class="container-fluid">
                    

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2" style="color:black;">Sales Order</h1>
                
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        <a href="{{route('superadmin.so.showrfo')}}" class="btn btn-pd btn-sm" id="buatSalesOrder">Buat Sales Order</a>
                        <span id="notificationBadge" class="badge badge-pill badge-danger"></span>

                        <script>
    // Ambil elemen tombol
    var button = document.getElementById('buatSalesOrder');
    
    // Fungsi untuk menampilkan notifikasi dengan jumlah yang diinginkan
    function showNotification(number) {
        var badge = document.getElementById('notificationBadge');
        badge.innerText = number;
        badge.style.display = 'inline';
    }
    
    // Panggil fungsi showNotification dengan jumlah yang diinginkan
    showNotification({{$rfo}}); // Ubah angka 5 sesuai dengan jumlah notifikasi yang diinginkan
</script>
                        </div>
                        <div class="card-body">
                        <div class="dataTables_length mb-3" id="myDataTable_length">
<label for="entries"> Show
<select id="entries" name="myDataTable_length" aria-controls="myDataTable"  onchange="changeEntries()" class>
<option value="10">10</option>
<option value="25">25</option>
<option value="50">50</option>
<option value="100">100</option>
</select>
entries
</label>
</div>

<div id="myDataTable_filter" class="dataTables_filter">
    <label for="search">Search
        <input id="search" placeholder>
    </label>
</div>
                            
                            <div class="table-responsive">
                            @include('components.alert')

                            <table  class="table table-bordered"  width="100%" cellspacing="0" style="border-radius: 10px;">
                <thead>
                    <tr>                 
                                       
                        <th>No Sales Order</th>
                        <th>RFO</th>
                        <th>Nama Customer</th>
                        <th>Tanggal SO</th>
                        <th>Produk</th>
                        <th>Status</th>
                        
                        <th>Status Update</th>
                        <th>Action</th>
                        <th></th>
                        <!-- <th></th> -->
                    </tr>
                </thead>
                <tbody>
             @foreach ($so as $data)
            <tr>
                <td>{{$data->no_so}}</td>
                <td>{{$data-> no_rfo}}</td>
                <td>{{$data  -> nama_customer}}</td>
                <td>{{ \Carbon\Carbon::parse($data->so_date)->format('d-m-Y') }}</td>                <td>    
                <a href="{{route('superadmintampilpesananso', $data->id)}}"><button type="button" class="btn btn-link">
         Lihat Detail Pesanan
                
            </a>
</td>
<td>
{{$data->status_so}}
</td>
<td>{{$data -> updated_at}}</td>
<td>
    <a id="cetakSalesOrder{{$data->id}}" href="{{route('superadmintampilso',$data->id)}}">
        Cetak Sales Order
    </a>

  
</td>
<script>
    $(document).ready(function(){
        // Cek apakah cookie sudah ada
        if (document.cookie.indexOf('salesOrderClicked{{$data->id}}=true') !== -1) {
            $('#cetakSalesOrder{{$data->id}}').html('Cetak Sales Order <i class="fas fa-check-circle" style="color:green"></i> ');
        }

        $('#cetakSalesOrder{{$data->id}}').click(function(){
            $(this).html(' Cetak Sales Order <i class="fas fa-check-circle" style="color:green"></i>');
            // Set cookie saat tombol diklik
            document.cookie = 'salesOrderClicked{{$data->id}}=true; expires=Fri, 31 Dec 9999 23:59:59 GMT';
        });
    });
</script>

<td>    
@if($data->status_so =="Terbit Invoice")
    <button type="button" class="btn btn-light btn-sm" style="cursor: not-allowed;" disabled>
    Cancel SO
</button>
@elseif($data->status_so =="Cancelled")
    <button type="button" class="btn btn-light btn-sm" style="cursor: not-allowed;" disabled>
    Cancel SO
</button>
    @else
<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal{{$data->id}}">
      Cancel SO
</button>
@endif
</td> 


<!-- <td>
    @if($data->cancel_approval == "Yes")

    Pengajuan Cancel

    ({{$data->alasan}})
    @endif

</td> -->
<!-- 
<td>    
@if($data->status_so =="Terbit Invoice")
    <button type="button" class="btn btn-light btn-sm" style="cursor: not-allowed;" disabled>
    Cancel SO
</button>
@elseif($data->status_so =="Cancelled")
    <button type="button" class="btn btn-light btn-sm" style="cursor: not-allowed;" disabled>
    Cancel SO
</button>
    @else
<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal{{$data->id}}">
      Cancel SO
</button>
@endif
</td> -->

            </tr>
            <div class="modal fade" id="exampleModal{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle" style="color:black;">Cancel SO - {{$data->no_so}}</h5>
       
      </div>
      <div class="modal-body">
      <form action="{{route('superadmincancelso')}}" method="post">
        @csrf
      <input type="hidden" name="so_id" value="{{$data->id}}">
      Yakin untuk melakukan pembatalan?
                
      </div>
      <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <button type="submit" class="btn btn-primary">Ya</button>
            </div>
            </form>
    </div>
  </div>
</div>     
@endforeach
   
                </tbody>

            </table>
     

                                <div class="dataTables_info" id="dataTableInfo" role="status" aria-live="polite">
    Showing <span id="showingStart">1</span> to <span id="showingEnd">10</span> of <span id="totalEntries">0</span> entries
</div>
        
<div class="dataTables_paginate paging_simple_numbers" id="myDataTable_paginate">
    
    <a href="#" class="paginate_button" id="doublePrevButton" onclick="doublePreviousPage()"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
    <a href="#" class="paginate_button" id="prevButton" onclick="previousPage()"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
    <span>
        <a id="pageNumbers" aria-controls="myDataTable" role="link" aria-current="page" data-dt-idx="0" tabindex="0"></a>
    </span>
    <a href="#" class="paginate_button" id="nextButton" onclick="nextPage()"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
    <a href="#" class="paginate_button" id="doubleNextButton" onclick="doubleNextPage()"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
</div>
                            </div>
                        </div>
                    </div>

                </div>


                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
           
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    
    <style>

.dataTables_paginate{float:right;text-align:right;padding-top:.25em}
.paginate_button {box-sizing:border-box;
    display:inline-block;
    min-width:1.5em;
    padding:.5em 1em;
    margin-left:2px;
    text-align:center;
    text-decoration:none !important;
    cursor:pointer;color:inherit !important;
    border:1px solid transparent;
    border-radius:2px;
    background:transparent}

.dataTables_length{float:left}.dataTables_wrapper .dataTables_length select{border:1px solid #aaa;border-radius:3px;padding:5px;background-color:transparent;color:inherit;padding:4px}
.dataTables_info{clear:both;float:left;padding-top:.755em}    
.dataTables_filter{float:right;text-align:right}
.dataTables_filter input{border:1px solid #aaa;border-radius:3px;padding:5px;background-color:transparent;color:inherit;margin-left:3px}


.btn-active {
    background-color: #007bff;
    color: #fff;
}

/* Styling for paginasi container */
.dataTables_paginate {
        text-align: center;
    }

    /* Styling for each paginasi button */
 
        /* Styling for paginasi container */
    .dataTables_paginate {
        text-align: center;
    }

    /* Styling for each paginasi button */
    .paginate_button {
        display: inline-block;
        margin: 5px;
        text-align: center;
        border: 1px solid #000; 
        padding: 5px 10px;
    }

    /* Media query for small screens */
    @media (max-width: 768px) {
        .paginate_button {
            padding: 3px 6px;
        }
    }

    /* Media query for extra small screens */
    @media (max-width: 576px) {
        .dataTables_paginate {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .paginate_button {
            padding: 2px 4px;
            margin: 2px;
            
        }
    }
        
    /* Media query for small screens */
    @media (max-width: 768px) {
        .paginate_button {
            padding: 3px 6px;
        }
    }

    /* Media query for extra small screens */
    @media (max-width: 576px) {
        .dataTables_paginate {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .paginate_button {
            padding: 2px 4px;
            margin: 2px;
        }
    }

</style>


<script>
    var itemsPerPage = 10; // Ubah nilai ini sesuai dengan jumlah item per halaman
    var currentPage = 1;
    var filteredData = [];
    
    function initializeData() {
    var tableRows = document.querySelectorAll("table tbody tr");
    filteredData = Array.from(tableRows); // Konversi NodeList ke array
    updatePagination();
}

// Panggil fungsi initializeData() untuk menginisialisasi data saat halaman dimuat
initializeData();
    
function doublePreviousPage() {
        if (currentPage > 1) {
            currentPage = 1;
            updatePagination();
        }
    }
    
function nextPage() {
    var totalPages = Math.ceil(document.querySelectorAll("table tbody tr").length / itemsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        updatePagination();
    }
}
  
function doubleNextPage() {
    var totalPages = Math.ceil(document.querySelectorAll("table tbody tr").length / itemsPerPage);
    if (currentPage < totalPages) {
        currentPage = totalPages;
        updatePagination();
    }
}

    function previousPage() {
        if (currentPage > 1) {
            currentPage--;
            updatePagination();
        }
    }
 
    function updatePagination() {
    var startIndex = (currentPage - 1) * itemsPerPage;
    var endIndex = startIndex + itemsPerPage;

    // Sembunyikan semua baris
    var tableRows = document.querySelectorAll("table tbody tr");
    tableRows.forEach(function (row) {
        row.style.display = 'none';
    });

    // Tampilkan baris untuk halaman saat ini
    for (var i = startIndex; i < endIndex && i < filteredData.length; i++) {
        filteredData[i].style.display = 'table-row';
    }

    // Update nomor halaman
    var totalPages = Math.ceil(filteredData.length / itemsPerPage);
    var pageNumbers = document.getElementById('pageNumbers');
    pageNumbers.innerHTML = '';

    var totalEntries = filteredData.length;

    document.getElementById('showingStart').textContent = startIndex + 1;
    document.getElementById('showingEnd').textContent = Math.min(endIndex, totalEntries);
    document.getElementById('totalEntries').textContent = totalEntries;

    var pageRange = 3; // Jumlah nomor halaman yang ditampilkan
    var startPage = Math.max(1, currentPage - Math.floor(pageRange / 2));
    var endPage = Math.min(totalPages, startPage + pageRange - 1);

    for (var i = startPage; i <= endPage; i++) {
        var pageButton = document.createElement('button');
        pageButton.className = 'btn btn-primary btn-sm mr-1 ml-1';
        pageButton.textContent = i;
        if (i === currentPage) {
            pageButton.classList.add('btn-active');
        }
        pageButton.onclick = function () {
            currentPage = parseInt(this.textContent);
            updatePagination();
        };
        pageNumbers.appendChild(pageButton);
    }
}
    function changeEntries() {
        var entriesSelect = document.getElementById('entries');
        var selectedEntries = parseInt(entriesSelect.value);

        // Update the 'itemsPerPage' variable with the selected number of entries
        itemsPerPage = selectedEntries;

        // Reset the current page to 1 when changing the number of entries
        currentPage = 1;

        // Update pagination based on the new number of entries
        updatePagination();
    }

    function applySearchFilter() {
    var searchInput = document.getElementById('search');
    var filter = searchInput.value.toLowerCase();
    
    // Mencari data yang sesuai dengan filter
    filteredData = Array.from(document.querySelectorAll("table tbody tr")).filter(function (row) {
        var rowText = row.textContent.toLowerCase();
        return rowText.includes(filter);
    });

    // Set currentPage kembali ke 1
    currentPage = 1;

    updatePagination();
}

updatePagination();

    // Menangani perubahan pada input pencarian
    document.getElementById('search').addEventListener('input', applySearchFilter);
    // Panggil updatePagination untuk inisialisasi
         
</script>

@endsection