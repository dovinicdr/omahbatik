<header id="header">
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" style="min-height: 80px;">
        <div class="container">
          <a class="navbar-brand" href="{{ url('/') }}#" style="font-weight: 500;">
            <img src="{{ asset('/') }}assets/img/logo.png" alt="Logo" width="30" class="d-inline-block align-text-top">
            Omah Batik Sukun
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ url('/') }}#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}#about">Tentang</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}#product">Produk</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}#articles">Artikel</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}#contact">Kontak</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/admin') }}">Login</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>
</header>