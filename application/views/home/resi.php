<div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Form Login</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5">
                <div class="contact-form"> 
                    <form name="sentMessage"  method="post" action="<?php echo site_url('main/save');?>">
                        <div class="control-group">
                        <input type="hidden" name="id" value="<?php echo $detailOrder->idDetailOrder; ?>" readonly>
                            <input type="text" name="resi" class="form-control" id="name" placeholder="Masukan Nomor Resi"
                                required="required" data-validation-required-message="Masukan nomor resi" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div>
                            <button class="btn btn-primary py-2 px-4" type="submit" id="sendMesrsageButton">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
