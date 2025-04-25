<head>

</head>

<body>

    <h1>Form Tambah</h1>
    <form action="action-tambah" method="post">
        @csrf

     <label for="">Angka1</label>
     <input type="number" name="angka1" required>
     <br><br>
     <label for="">Angka2</label>
     <input type="number" name="angka2" required>
     <br><br>
     <button type="submit">Proses</button>

    </form>
    <br><br>
    
    <h3>Totalnya adalah: {{$jumlah}} </h3>
</body>
