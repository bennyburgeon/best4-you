@extends('layouts.frontend')
@section('title', 'Best Job Consultancy in India | Best4U Careers')
@section('meta_description', 'Find the best job consultancy in Kerala for freshers and experienced professionals. Explore the latest job opportunities and get reliable career guidance and placement support.')
@section('canonical')
<link rel="canonical" href="https://best4ucareers.com/" />
@endsection
@section('og_tags')
<meta property="og:url" content="https://best4ucareers.com/">
<meta property="og:type" content="website">
<meta property="og:title" content="Best Job Consultancy in India | Best4U Careers">
<meta property="og:description" content="Find the best job consultancy in Kerala for freshers and experienced professionals. Explore the latest job opportunities and get reliable career guidance and placement support.">
<meta property="og:image" content="{{ asset('public/frontend/assets/img/logo.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="https://best4ucareers.com/">
<meta name="twitter:title" content="Best Job Consultancy in India | Best4U Careers">
<meta name="twitter:description" content="Find the best job consultancy in Kerala for freshers and experienced professionals. Explore the latest job opportunities and get reliable career guidance and placement support.">
<meta name="twitter:image" content="{{ asset('public/frontend/assets/img/logo.jpg') }}">
@endsection
@section('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "EmploymentAgency",
  "name": "Best4U Careers",
  "url": "https://best4ucareers.com/",
  "telephone": "+91 7594008787",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "1587/H, Elayambari House (Ambadi Building), Florican Road, Malaparamba, Kozhikode, Kerala",
    "addressLocality": "Kozhikode",
    "postalCode": "673009",
    "addressCountry": "IN"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 11.2923445,
    "longitude": 75.79813860000002
  },
  "openingHoursSpecification": {
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
    "opens": "09:00",
    "closes": "06:00"
  },
  "sameAs": [
    "https://www.facebook.com/bestforyouhrconsultancyIndia/",
    "https://www.instagram.com/bestforyouhrconsultancy_India/"
  ]
}
</script>
@endsection

@push('styles')
<style>
/* Desktop Search Bar & Slider Enhancements */
.slider {
  position: relative !important;
}

.slider .single-slider {
  height: 700px !important;
}

.global-search-overlay {
  position: absolute;
  left: 0;
  z-index: 100;
  pointer-events: none;
  top: auto !important;
  bottom: 210px !important;
  transform: none !important;
}

.search-container {
  border-radius: 50px;
  padding: 6px 6px 6px 20px;
  background: #fff;
  transition: all 0.3s ease;
  box-shadow: 0 15px 45px rgba(31, 64, 121, 0.12) !important;
}

/* Mobile/Tablet Responsive Styles */
@media (max-width: 991px) {
  .slider .single-slider {
    height: 380px !important; /* Keep mobile height */
  }

  .global-search-overlay {
    position: relative !important;
    top: 0 !important;
    bottom: auto !important;
    transform: none !important;
    margin-top: -40px !important;
    margin-bottom: 30px !important;
    z-index: 110 !important;
    pointer-events: auto !important;
  }
  
  .slider {
    padding-bottom: 10px !important;
  }

  .search-container {
    border-radius: 20px !important;
    padding: 18px 20px !important;
  }

  .search-container .col-lg-5,
  .search-container .col-lg-4 {
    border-bottom: 1px solid #e2e8f0;
    border-right: 0 !important;
    padding-bottom: 10px;
    margin-bottom: 10px;
  }

  .search-container .ms-3,
  .search-container .ml-3 {
    margin-left: 0 !important;
  }

  .search-container .col-lg-3 {
    margin-top: 12px;
  }
  
  .search-container .input-group i {
    font-size: 16px;
    margin-right: 10px;
  }
}
.regions-section .card:hover {
  transform: translateY(-8px);
}
</style>
@endpush




