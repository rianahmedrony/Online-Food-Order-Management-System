<header class="sticky-top">
  <nav class="navbar navbar-expand-md navbar-bg-white navbar-light p-2 border-bottom">
    <div class="container-md">
      <a href="/" class="navbar-brand">
        <img src="/assets/images/logo.png" alt="ICEFoods" class="logo">
      </a>
      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar-nav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse gap-3 navbar-nav-darkbg" id="navbar-nav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="/">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">
              Foods
            </a>
            <ul class="dropdown-menu">
              <?php
              // Get all categories
              $query = "SELECT cat, img FROM foods GROUP BY cat";
              $catsResult = $db->query($query);
              $categories = $catsResult->fetchAll();
              foreach ($categories as $category) :
                $cat = ucfirst($category['cat']);
              ?>
                <li><a class="dropdown-item" href="/category.php?cat=<?= $category['cat'] ?>"><?= $cat ?></a></li>
              <?php endforeach ?>
            </ul>
          </li>
          <?php
          if (!isset($_SESSION['user'])) :
          ?>
            <li class="nav-item">
              <a class="nav-link" href="/user/login.php">Login</a>
            </li>
          <?php endif ?>

        </ul>
        <form method="GET" action="/search.php" class="nav-search">
          <div class="input-group-sm d-flex justify-content-between">
            <input class="search-field bg-transparent" type="text" name="q" id="" placeholder="Search for foods..">
            <button class="search-btn navbar-text">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 1.3rem">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6.35-6.35a8 8 0 10-1.4 1.4L21 21z" />
              </svg>
            </button>
          </div>
        </form>
        <?php
        if (isset($_SESSION['user'])) :
        ?>
          <ul class="d-flex navbar-nav flex-row">
            <li class="navbar-text p-md-2 me-3">
              <a class="cart-icon position-relative" href="/user/cart.php">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 1.5rem">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
                <span id="cart-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success cart-count" style="font-size: 0.6rem">
                  <?php
                  $cart = $_SESSION['cart'] ?? [];
                  $cartCount = count($cart);
                  echo $cartCount;
                  ?>
                  <span class="visually-hidden">Cart items</span>
                </span>
              </a>
            </li>
            <li class="dropdown navbar-text user-icon">
              <a role="button" data-bs-toggle="dropdown">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 1.5rem;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </a>
              <ul class="dropdown-menu" style="left: unset; right: 0;">
                <li><a class="dropdown-item" style="color: #282828" href="/user/profile.php">My Profile</a></li>
                <li><a class="dropdown-item" style="color: #282828" href="/user/orders.php">My Orders</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" style="color: #282828" href="/user/logout.php">Logout</a></li>
              </ul>
            <?php endif ?>
      </div>
    </div>
  </nav>
</header>