<div class="container-fluid">
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <div class="btn btn-sm btn-primary">
        <?php
        $grand_total = 0;
        if ($keranjang = $this->cart->contents()) {
          foreach ($keranjang as $item) {
            $grand_total = $grand_total + $item['subtotal'];
          }

          echo "<h4>Total Pembayaran Belanja Anda : Rp. " . number_format($grand_total, 0, ',', '.');
        ?>

      </div><br>

      <form method="post" action="<?php echo base_url('index.php/Dashboard/proses_pemesanan') ?>">
        <div class="form-group">
          <label>Nama </label>
          <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap Anda" class="form-control">
        </div>
        <div class="form-group">
          <label>Alamat Lengkap</label>
          <input type="text" class="form-control" name="alamat" placeholder="Alamat Lengkap Anda" class="form-control">
        </div>
        <div class="form-group">
          <label>No. Telp</label>
          <input type="number_format" class="form-control" name="no_telp" placeholder="No Telp /HP Anda" class="form-control">
        </div>
        <div class="form-group">
          <label>Jasa Pengiriman</label>
          <select class="form-control">
            <option>JNE</option>
            <option>J&T</option>
            <option>POS Indonesia</option>
            <option>TIKI</option>
            <option>Wahana</option>
          </select>
        </div>
        <div class="form-group">
          <label>Pilihan Bank Pembayaran</label>
          <select class="form-control">
            <option>BRI - 01234567</option>
            <option>BCA - 02345789</option>
            <option>BNI - 03455668</option>
          </select>
        </div>
        <button type="submit" class="btn btn-sm btn-success">Pesan</button>


      </form>


    </div>
    </a>

  </div>
  </a>

<?php
        } else {
          echo "<h4>Keranjang Masih Kosong";
        }
?>
</div>
</div>
</div>

</div>