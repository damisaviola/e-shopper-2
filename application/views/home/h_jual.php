 <!-- Page Header Start -->
 <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shopping Cart</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

      <!-- Cart Start -->
      <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-12 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>ID Order</th>
                            <th>ID Detail Order</th>
                            <th>Date</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Resi</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                    <?php if (!empty($orders)): ?>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td class="align-middle"><?php echo $order['idOrder']; ?></td>
            <td class="align-middle"><?php echo $order['idDetailOrder']; ?></td>
            <td class="align-middle"><?php echo date('d-m-Y', strtotime($order['tglOrder'])); ?></td>
            <td class="align-middle"><?php echo $order['namaProduk']; ?></td>
            <td class="align-middle"><?php echo number_format($order['harga'], 2); ?></td>
            <td class="align-middle"><?php echo $order['jumlah']; ?></td>
            <td class="align-middle"><?php echo number_format($order['harga'] * $order['jumlah'], 2); ?></td>
            <td class="align-middle">
                <?php echo $order['nomor_resi']; ?>
                <?php if (empty($order['nomor_resi'])): ?>
                    <a href="<?php echo site_url('main/get_by_id/' . $order['idDetailOrder']); ?>">
                        <button type="button" class="btn btn-secondary">Edit</button>
                    </a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="8" class="text-center">No orders found.</td>
    </tr>
<?php endif; ?>

</tbody>

                </table>
            </div>
        </div>
    </div>
    <!-- Pastikan A
    <!-- Cart End -->
