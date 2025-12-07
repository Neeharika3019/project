<?php
// Start session BEFORE anything else
session_start();

// DB connection
include '../db.php';

// ---------------- SPECIALS FROM DATABASE ----------------
$specials = [];
$sql = "SELECT * FROM specials";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $specials[] = $row;
}

// ---------------- TESTIMONIALS FROM DATABASE ----------------
$testimonials = [];
$sql = "SELECT * FROM testimonials ORDER BY id DESC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $testimonials[] = $row;
}
?>

<!---Page META & RESOURCES-------->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Basilico — Authentic Italian Cuisine in Mauritius</title>
<!----Linkes CSS files(header.css & homestyles.css)----------------->
  <link rel="stylesheet" href="../header.css">
  <link rel="stylesheet" href="homestyles.css">

  <link rel="icon" href="assets/img/basilico-logo.png">
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>

<body>
 <!-----------Navigation Bar ------------------>
    <?php include '../header.php'; ?>
    
<!-- ================= HERO SECTION ================= -->
<section id="home" class="hero">
  <div class="container hero__grid">

    <div class="hero__text">
      <h1 class="hero__title">Basilico</h1>
      <p class="hero__subtitle">Authentic Italian Cuisine in Mauritius</p>
      <p class="hero__copy">
        Basilico is a cozy Italian eatery serving fresh, hand-made spaghetti dishes.
        From classic recipes to creative twists, every plate is crafted with authentic
        Italian flavors in a warm and inviting atmosphere.
      </p>
         <!----Button that direct the user to order RESERVATION page----->
      <a class="btn primary" href="../reservation/reservation.php">Make a Reservation</a>
    </div>

    <figure class="hero__media">
      <img src="../assets/img/hero-pasta.jpg" alt="Fresh pasta being made">
    </figure>

  </div>
</section>

<!-- ================= WEEKLY SPECIALS ================= -->
<section id="specials" class="specials">
  <div class="container">
    <h2 class="section-title">This week specials!</h2>

    <div class="card-grid">

      <?php foreach ($specials as $item): ?>
        <article class="card special">

          <figure class="card_media">
            <img src="<?= htmlspecialchars($item['image_url']) ?>" 
                 alt="<?= htmlspecialchars($item['dish_name']) ?>">
          </figure>

          <div class="card_body">
            <h3 class="card_title"><?= htmlspecialchars($item['dish_name']) ?></h3>

            <div class="price">Rs <?= htmlspecialchars($item['price']) ?></div>

            <p class="card_text">
              <?= htmlspecialchars($item['description']) ?>
            </p>
          <!----Button that direct the user to ORDER ONLINE page----->
            <a class="btn primary" href="../order/orderonline.php?id=<?= $item['id'] ?>">Order a Deliver</a>
          </div>

        </article>
      <?php endforeach; ?>

    </div>
  </div>
</section>

<!-- ================= TESTIMONIALS ================= -->
<section id="testimonials" class="testimonials">
  <div class="container">
    <h2 class="section-title">Testimonials</h2>

    <div class="testimonial-grid">

      <?php foreach ($testimonials as $t): ?>
      <figure class="testimonial">

        <figcaption class="testimonial__meta">
          <span class="user"><?= htmlspecialchars($t['username']) ?></span>

          <span class="stars">
            <?php for ($i=0; $i < 5; $i++): ?>
              <span class="star<?= $i < $t['rating'] ? ' star--on' : '' ?>">★</span>
            <?php endfor; ?>
          </span>
        </figcaption>

        <blockquote class="testimonial__text">
          “<?= htmlspecialchars($t['text']) ?>”
        </blockquote>

      </figure>
      <?php endforeach; ?>

    </div>
  </div>
</section>

<!-- ================= ABOUT SECTION ================= -->
<section id="about" class="about">
  <div class="container about__grid">

    <div class="about__text">
      <h2>Basilico</h2><br />
      <p class="tagline">Authentic Italian Cuisine in Mauritius</p><br />
      <p>
        Basilico brings Italy to Mauritius with fresh, hand-crafted spaghetti in every style — 
        from timeless classics to unique creations — served with warmth and tradition.
      </p>
    </div>

    <figure class="about__gallery">
        <img src="../assets/img/restaurant-interior.jpg" class="about__img about__img--base" alt="Restaurant interior">
        <img src="../assets/img/pasta-bowl.jpg" class="about__img about__img--overlay" alt="Pasta bowl">
    </figure>


  </div>
</section>

<!-- ================= Footer ================= -->
   <footer class="footer">
        <div class="footer-logo">
            <img src="../assets/img/basilico-footer.png" alt="Basilico Logo">
        </div>

        <div class="footer-columns">
            <div class="footer-column">
                <h4>Doormat Navigation</h4>
                <p>Home</p>
                <p>Menu</p>
                <p>Reservation</p>
                <p>Order Online</p>
                <p>Registration</p>
                <p>Login</p>
            </div>
            <div class="footer-column">
                <h4>Contact</h4>
                <p>📍 Port Louis, Mauritius</p>
                <p>📞 +230 5555 1234</p>
                <p>✉️ contact@basilico.mu</p>
            </div>
            <div class="footer-column">
                <h4>Opening Hours</h4>
                <p>Mon-Fri: 11 00 AM - 10 00 PM</p>
                <p>Sat-Sun: 12 00 PM - 11.30 PM</p>
            </div>
        </div>
    </footer>