<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/pagehead.php';
include($root . '/inc/header.php'); ?>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
</head>

<body>
  <?php include($root . '/inc/navbar.php'); ?>
  <div class="hero">
    <div class="hero__content px-3">
      <h1 class="display-3 hero-title">Delicious Foods</h1>
      <p>We pride ourselves on using only the finest, freshest ingredients to create exceptional dishes that are sure to delight your taste buds.</p>
      <button class="btn btn-primary mt-2" id="explore">Explore Now</button>
    </div>
  </div>
  <div class="container-md">
    <section id="categories">
      <div class="category-list">
        <?php
        // Show all categories
        foreach ($categories as $category) :
          $cat = ucfirst($category['cat']);
          $img = $category['img'];
        ?>
          <a class="category-tile" href="/category.php?cat=<?= $category['cat'] ?>">
            <div class="category-tile__img">
              <img src="/assets/images/foods/<?= $img ?>" alt="<?= $cat ?>" />
            </div>
            <h6 class="category-tile__title"><?= $cat ?></h6>
          </a>
        <?php endforeach; ?>
    </section>
    <section class="row">
      <div class="mt-6 col-md-9">
        <?php
        foreach ($categories as $category) :
          $cat = $category['cat'];

          // Get foods from each category
          $sql = "SELECT * FROM foods WHERE cat = '$cat' LIMIT 4";
          $result = $db->query($sql);
          $count = $result->rowCount();

          if ($count > 0) :
        ?>
            <h3 class="mb-3 mb-md-4"><?= ucfirst($cat) ?></h3>
            <div class="foodlist">
              <?php
              while ($row = $result->fetch()) {
                $id = $row['id'];
                $title = $row['name'];
                $price = $row['price'];
                $img = $row['img'];

                include($root . '/inc/foodcard.php');
              }
              ?>
            </div>
            <div class="mb-4 d-flex justify-content-end">
              <a href="/category.php?cat=<?= $cat ?>" class="btn btn-primary btn-sm mt-3">View All &raquo;</a>
            </div>
        <?php endif;
        endforeach; ?>
      </div>
      <div class="col-md-3 d-flex flex-column gap-3 flyers" style="position: sticky; top: 6rem; height: fit-content;">
        <?php
        // Show random flyers
        $flyersDir = $root . '/assets/images/flyers';
        $flyers = scandir($flyersDir);
        shuffle($flyers);

        $n = 1;
        foreach ($flyers as $flyer) :
          if ($flyer == '.' || $flyer == '..')
            continue;
        ?>
          <img src="/assets/images/flyers/<?= $flyer ?>" alt="" class="img-thumbnail">
        <?php
          // if ($n == 3) break;
          $n++;
        endforeach; ?>

      </div>
    </section>
    <section>
      <div class="row d-flex justify-content-center">
        <div class="col-md-10 col-xl-8 text-center">
          <h3 class="mb-4">Our Customer Reviews</h3>
        </div>
      </div>

      <div class="row text-center">
        <div class="col-md-4 mb-3 mb-md-0">
          <div class="card">
            <div class="card-body">
              <h5 class="mb-3">Md. Tohidul Islam</h5>
              <h6 class="text-primary mb-3">Automation Expert</h6>
              <p class="px-xl-3">
                I've been ordering from this online food-order restaurant for months now and I have never been disappointed. Their menu has something for everyone, and their ingredients are always fresh and delicious. Their delivery is always on time. I highly recommend them!
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
          <div class="card">
            <div class="card-body">
              <h5 class="mb-3">Md. Mehedi Hasan</h5>
              <h6 class="text-primary mb-3">Web Developer</h6>
              <p class="px-xl-3">
                This online food-order restaurant has become my go-to for delicious, affordable meals. Their menu is extensive, and their prices are great. I love that I can order from them anytime and have my food delivered right to my door. I've recommended them to all my friends and family!
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
          <div class="card">
            <div class="card-body">
              <h5 class="mb-3">Ahsan Habib</h5>
              <h6 class="text-primary mb-3">Graphics Designer</h6>
              <p class="px-xl-3">
                I was skeptical about ordering food online, but this restaurant has completely exceeded my expectations. Their food is always hot and fresh, and their customer service is exceptional. I highly recommend this online food-order restaurant to anyone looking for great food and service!
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <?php include($root . '/inc/footer.php'); ?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/js-confetti@latest/dist/js-confetti.browser.js"></script>
  <script>
    // Flyer slider
    $(document).ready(function() {
      $('.flyers').slick({
        vertical: true,
        verticalSwiping: true,
        autoplay: true,
        arrows: false,
        slidesToShow: 4,
        infinite: true,
        responsive: [{
          breakpoint: 768,
          settings: {
            draggable: false,
            swipe: false,
            slidesToShow: 1,
          }
        }],
      });
    });

    // Sticky navbar
    document.addEventListener("DOMContentLoaded", function() {
      header = document.querySelector("header");
      let navBar = document.querySelector("nav");

      header.classList.remove("sticky-top");
      header.classList.add("fixed-top");
      navBar.classList.add("navbar-dark");
      navBar.classList.remove("border-bottom", "navbar-bg-white");
    });

    // Change navbar bg on scroll
    window.addEventListener("scroll", function() {
      let scrollPosition = window.scrollY;
      let navBar = document.querySelector("nav");
      let navBarNav = document.querySelector("#navbar-nav");

      if (scrollPosition > 0) {
        navBar.classList.add("navbar-bg-white", "navbar-light", "border-bottom");
        navBar.classList.remove("navbar-dark");
        navBarNav.classList.remove("navbar-nav-darkbg");
      } else {
        navBar.classList.add("navbar-dark");
        navBar.classList.remove("navbar-bg-white", "navbar-light", "border-bottom");
        navBarNav.classList.add("navbar-nav-darkbg");
      }
    });

    // Confetti
    const jsConfetti = new JSConfetti()
    document.querySelector("#explore").addEventListener("click", function(e) {
      window.scrollTo({
        top: document.querySelector("#categories").offsetTop - 100,
        behavior: "smooth"
      });
      jsConfetti.addConfetti({
        emojis: ['🍔', '🍟', '🌭', '🍕', '🌮', '🌯', '🥪', '🥙', '🧆', '🥗', '🥘', '🍲', '🥣', '🍱', '🍛', '🍜', '🍝', '🍠', '🍢', '🍣', '🍤', '🍥', '🥮', '🍡', '🥟', '🥠', '🥡', '🍦', '🍧', '🍨', '🍩', '🍪', '🎂', '🍰', '🧁', '🥧', '🍫', '🍬', '🍭', '🍮', '🍯', '🍼', '🥛', '🍵', '🍶', '🍾', '🍷', '🍸', '🍹', '🍺', '🍻', '🥂', '🥃', '🥤', '🧃', '🧉', '🧊', '🥢', '🍽️', '🍴', '🥄'],
        emojiSize: 20,
        confettiNumber: 200,
      })
    });
  </script>
</body>

</html>