// Scroll to top button
window.addEventListener("scroll", function () {
  var scroll = document.querySelector("#scroll-top");
  scroll.classList.toggle("show", window.scrollY > 500);
});

document.querySelector("#scroll-top").addEventListener("click", function () {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
});

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  "use strict";

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll(".needs-validation");

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add("was-validated");
      },
      false
    );
  });
})();

// Add to cart button action
const addToCartBtns = document.querySelectorAll(".add-to-cart");
addToCartBtns.forEach((btn) => {
  btn.addEventListener("click", addToCart);
});

function addToCart(e) {
  const foodItem = e.target.parentElement.parentElement.parentElement;
  const foodId = foodItem.dataset.foodId;
  const foodName = foodItem.querySelector(".food-name").innerHTML;

  const food = {
    food_id: foodId,
  };

  let params = {
    method: "POST",
    headers: {
      "Content-Type": "application/json; charset=utf-8",
    },
    body: JSON.stringify(food),
  };

  fetch("/user/ajax/add_to_cart.php", params)
    .then((response) => response.json())
    .then((data) => {
      if (data.status == "success") {
        Toastify({
          text: foodName + " added to cart",
          duration: 3000,
          destination: "/user/cart.php",
          newWindow: true,
          close: false,
          gravity: "bottom", // `top` or `bottom`
          position: "right", // `left`, `center` or `right`
          stopOnFocus: true, // Prevents dismissing of toast on hover
          onClick: function () {}, // Callback after click
        }).showToast();

        updateCartCount(data.cart_count);
      } else if (data.status == "nedd_logged_in") {
        Swal.fire({
          title: "Error!",
          text: data.message,
          icon: "error",
          showCancelButton: true,
          confirmButtonText:
            "<a class='text-light' href='/user/login.php'>Login now</a",
          cancelButtonText: "Cancel",
          reverseButtons: true,
        });
      } else {
        Swal.fire({
          title: "Error!",
          text: data.message,
          icon: "error",
        });
      }
    });
}

function updateCartCount(cartCount) {
  document.querySelector(".cart-count").innerHTML = cartCount;
}
