<div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shop Detail</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shop Detail</p>
            </div>
        </div>
    </div>
   

    <?php
$total_reviews = count($reviews);
$total_rating = 0;

foreach ($reviews as $review) {
    $total_rating += $review['rating'];
}

$average_rating = ($total_reviews > 0) ? round($total_rating / $total_reviews, 1) : 0;
?>

   
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="<?php echo base_url('assets/foto_produk/' .$produk->foto);?>" alt="Image">
                        </div>
                        </div>
                       </div>
                </div>
            

                
            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold"><?php echo $produk->namaProduk; ?></h3>
                <div class="d-flex mb-3">
                <div class="text-primary mr-2">
                <?php
        
                $full_stars = floor($average_rating);
                $half_star = ($average_rating - $full_stars) > 0 ? true : false;
                $empty_stars = 5 - ceil($average_rating);

                for ($i = 0; $i < $full_stars; $i++) {
                    echo '<small class="fas fa-star"></small>';
                }

                if ($half_star) {
                    echo '<small class="fas fa-star-half-alt"></small>';
                }

                for ($i = 0; $i < $empty_stars; $i++) {
                    echo '<small class="far fa-star"></small>';
                }
                ?>
            </div>
            <small class="pt-1">(<?php echo $total_reviews; ?> Review<?php echo ($total_reviews > 1) ? 's' : ''; ?>)</small>
            </div>
                <h3 class="font-weight-semi-bold mb-4"> <h6>Rp <?php echo number_format($produk->harga, 0, ',', '.'); ?></h6>
                <p class="mb-4">Volup erat ipsum diam elitr rebum et dolor. Est nonumy elitr erat diam stet sit clita ea. Sanc invidunt ipsum et, labore clita lorem magna lorem ut. Erat lorem duo dolor no sea nonumy. Accus labore stet, est lorem sit diam sea et justo, amet at lorem et eirmod ipsum diam et rebum kasd rebum.</p>
                <div class="d-flex mb-3">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Sizes:</p>
                    <form>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-1" name="size">
                            <label class="custom-control-label" for="size-1">XS</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-2" name="size">
                            <label class="custom-control-label" for="size-2">S</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-3" name="size">
                            <label class="custom-control-label" for="size-3">M</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-4" name="size">
                            <label class="custom-control-label" for="size-4">L</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-5" name="size">
                            <label class="custom-control-label" for="size-5">XL</label>
                        </div>
                    </form>
                </div>
                <div class="d-flex mb-4">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Colors:</p>
                    <form>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-1" name="color">
                            <label class="custom-control-label" for="color-1">Black</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-2" name="color">
                            <label class="custom-control-label" for="color-2">White</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-3" name="color">
                            <label class="custom-control-label" for="color-3">Red</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-4" name="color">
                            <label class="custom-control-label" for="color-4">Blue</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-5" name="color">
                            <label class="custom-control-label" for="color-5">Green</label>
                        </div>
                    </form>
                </div>
                <div class="d-flex align-items-center mb-4 pt-2">
                   <a href="<?php echo site_url('main/add_cart/'.$produk->idProduk);?>"> <button class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button></a>
                </div>
                <div class="d-flex pt-2">
                    <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Information</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews (<?php echo count($reviews); ?>) </a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Product Description</h4>
                        <?php echo $produk->deskripsiProduk; ?>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-2">
                        <h4 class="mb-3">Additional Information</h4>
                        <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam, ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr sanctus eirmod takimata dolor ea invidunt.</p>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                    </li>
                                  </ul> 
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                    </li>
                                  </ul> 
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
    <div class="row">
    <div class="col-md-6">
    <h4 class="mb-4"><?php echo count($reviews); ?> review<?php echo (count($reviews) > 1) ? 's' : ''; ?> for "<?php echo $product['namaProduk']; ?>"</h4>
    
    <?php if (!empty($reviews)) : ?>
        <?php foreach ($reviews as $review) : ?>
            <div class="media mb-4">
                <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                <div class="media-body">
                    <h6><?php echo $review['name']; ?><small> - <i><?php echo date('d M Y', strtotime($review['created_at'])); ?></i></small></h6>
                    <div class="text-primary mb-2">
                        <?php 
                        $rating = $review['rating'];
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $rating) {
                                echo '<i class="fas fa-star"></i>';
                            } elseif ($i - $rating <= 0.5) {
                                echo '<i class="fas fa-star-half-alt"></i>';
                            } else {
                                echo '<i class="far fa-star"></i>';
                            }
                        }
                        ?>
                    </div>
                    <p><?php echo $review['message']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No reviews yet.</p>
    <?php endif; ?>

</div>

        
        <div class="col-md-6">
    <h4 class="mb-4">Leave a review</h4>
    <small>Your email address will not be published. Required fields are marked *</small>
    <div class="d-flex my-3">
        <p class="mb-0 mr-2">Your Rating * :</p>
        <div class="text-primary" id="star-rating">
            <i class="far fa-star" data-rating="1"></i>
            <i class="far fa-star" data-rating="2"></i>
            <i class="far fa-star" data-rating="3"></i>
            <i class="far fa-star" data-rating="4"></i>
            <i class="far fa-star" data-rating="5"></i>
        </div>
    </div>
    <form method="post" action="<?php echo site_url('main/submit_review'); ?>">
    <input type="hidden" id="rating" name="rating" value="0">
    <div class="form-group">
        <label for="message">Your Review *</label>
        <textarea id="message" name="message" cols="30" rows="5" class="form-control"><?php echo set_value('message'); ?></textarea>
        <?php echo form_error('message'); ?>
    </div>
    <div class="form-group">
        <label for="name">Your Name *</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name'); ?>">
        <?php echo form_error('name'); ?>
    </div>
    <div class="form-group">
        <label for="email">Your Email *</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo set_value('email'); ?>">
        <?php echo form_error('email'); ?>
    </div>
    <div class="form-group mb-0">
        <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
    </div>
    <input type="hidden" name="product_id" value="<?php echo $product['idProduk']; ?>">
</form>

</div>

    </div>
</div>

                </div>
            </div>
        </div>
    </div>

  <br> <br>
    
  <div class="container-fluid py-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                <?php 
                
                $limitedRecommendedProducts = array_slice($recommendedProducts, 0, 5); 
                foreach ($limitedRecommendedProducts as $val) : ?>
                    <div class="card product-item border-0">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="<?php echo base_url('assets/foto_produk/' . $val->foto); ?>" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3"><?php echo $val->namaProduk; ?></h6>
                            <div class="d-flex justify-content-center">
                                <h6><?php echo 'Rp' . number_format($val->harga, 2); ?></h6> 
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="<?php echo site_url('produk/detail/' . $val->idProduk); ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="#" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>


    <script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const stars = document.querySelectorAll('#star-rating i');
        const ratingInput = document.getElementById('rating');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const rating = star.getAttribute('data-rating');
                ratingInput.value = rating;
                updateStars(rating);
            });
        });

        function updateStars(rating) {
            stars.forEach(star => {
                if (star.getAttribute('data-rating') <= rating) {
                    star.classList.remove('far');
                    star.classList.add('fas');
                } else {
                    star.classList.remove('fas');
                    star.classList.add('far');
                }
            });
        }
    });
</script>
