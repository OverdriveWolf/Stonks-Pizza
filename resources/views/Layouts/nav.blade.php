<nav class="navbar">
    <div class="navbar-left">
        <a href="/home"><img src="{{ asset('logo2.png') }}" alt="Logo" class="logo"></a>
        <a href="/home"><span class="brand-name">Stonks Pizza</span></a>
    </div>

    <!-- Hamburger button (mobile only) -->
    <button class="hamburger" onclick="document.querySelector('.navbar-center').classList.toggle('show')">
        ☰
    </button>

    <ul class="navbar-center">
        <li><a href="/about-us">About Us</a></li>
        <li><a href="/menu">Menu</a></li>
    </ul>

    <div class="navbar-right">
        <a href="/winkelwagentje">
            <img src="{{ asset('cart.png') }}" alt="Cart" class="cart-icon">
        </a>
    </div>
</nav>


