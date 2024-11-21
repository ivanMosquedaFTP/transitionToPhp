<?php require('admin/views/headerFromDocumentRoot.php');?>
<center>
  <main>
    <section class="carousel">
      <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="image/index_car_1.jpg" d-block w-100" alt="..." height="auto" width="auto">
            <!-- <img src="image/index_car_1.jpg" d-block w-100" alt="..."> -->
          </div>
          <div class="carousel-item">
            <img src="image/index_car_2.jpg" d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="image/index_car_3.jpg" d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="image/index_car_4.jpg" d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="image/index_car_5.jpg" d-block w-100" alt="...">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </section>
    <br>
    <section class="testimonios">
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-5">
          <div class="card w-100" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">Testimonio 1</h5>
              <p class="card-text">"Llevo 3 compras actualmente y realmente estoy muy satisfecho con la calidad y la
                variedad de los productos que vende."</p>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="card w-100" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">Testimonio 2</h5>
              <p class="card-text">"Es un buen lugar, venden buena variedad de gorras y me gusta mucho su estética"</p>
            </div>
          </div>
        </div>
        <div class="col-md-1"></div>
      </div>
    </section>

    <div class="b-example-divider"></div>
    <?php require('admin/views/registerUserSnippet.php');?>
    <br>
  </main>
</center>
<?php require('admin/views/footerFromDocumentRoot.php');?>