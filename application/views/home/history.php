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
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                    <?php if(!empty($order)): ?>
                        <?php foreach ($order as $item): ?>
                        <tr>
                            <td class="align-middle"><img src="img/product-1.jpg" alt="" style="width: 50px;"><?php echo $item->namaProduk; ?></td>
                            <td class="align-middle"><?php echo "Rp " . number_format($item->harga); ?></td>
                            <td class="align-middle"><?php echo $item->jumlah; ?></td>
                            <td class="align-middle"> <?php
                    $total = $item->harga * $item->jumlah;
                    echo "Rp " . number_format($total);
                    ?></td>
                            <td class="align-middle"><button class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button></td>
                        </tr>
                        
                        <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No orders found.</td>
                </tr>
            <?php endif; ?>
                       
                       
                    </tbody>
                </table>
            </div>
        
        </div>
    </div>
    <!-- Cart End -->
