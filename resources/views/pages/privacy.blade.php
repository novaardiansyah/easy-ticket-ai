@php
  $texts = [
    'en' => [
      'title' => 'Privacy Policy',
      'updated' => 'Last updated: July 6, 2026',
      'intro' => 'Easy Ticket AI ("we", "our", "us") respects your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our application.',
      'collect_title' => 'Information We Collect',
      'collect_1' => 'Personal identification information (Name, email address)',
      'collect_2' => 'Login credentials (password, OAuth tokens)',
      'collect_3' => 'Usage data (pages visited, features accessed)',
      'collect_4' => 'Device information (browser type, IP address)',
      'use_title' => 'How We Use Your Information',
      'use_1' => 'To provide and maintain our service',
      'use_2' => 'To notify you about changes to our service',
      'use_3' => 'To allow you to participate in interactive features',
      'use_4' => 'To provide customer support',
      'share_title' => 'Information Sharing',
      'share' => 'We do not sell your personal information. We may share data with third-party service providers who assist us in operating our application (e.g., cloud hosting, email delivery).',
      'security_title' => 'Data Security',
      'security' => 'We implement appropriate technical and organizational measures to protect your personal data. However, no electronic transmission or storage is 100% secure.',
      'cookies_title' => 'Cookies',
      'cookies' => 'We use session cookies to authenticate you and maintain your session. You can control cookie preferences in your browser settings.',
      'contact_title' => 'Contact Us',
      'contact' => 'If you have questions about this Privacy Policy, contact us at ',
      'contact_link' => 'admin@novaardiansyah.id',
    ],
    'id' => [
      'title' => 'Kebijakan Privasi',
      'updated' => 'Terakhir diperbarui: 6 Juli 2026',
      'intro' => 'Easy Ticket AI ("kami") menghormati privasi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, mengungkapkan, dan melindungi informasi Anda saat menggunakan aplikasi kami.',
      'collect_title' => 'Informasi yang Kami Kumpulkan',
      'collect_1' => 'Informasi identifikasi pribadi (Nama, alamat email)',
      'collect_2' => 'Kredensial login (kata sandi, token OAuth)',
      'collect_3' => 'Data penggunaan (halaman yang dikunjungi, fitur yang diakses)',
      'collect_4' => 'Informasi perangkat (tipe browser, alamat IP)',
      'use_title' => 'Cara Kami Menggunakan Informasi Anda',
      'use_1' => 'Untuk menyediakan dan memelihara layanan kami',
      'use_2' => 'Untuk memberi tahu Anda tentang perubahan layanan',
      'use_3' => 'Untuk memungkinkan Anda berpartisipasi dalam fitur interaktif',
      'use_4' => 'Untuk memberikan dukungan pelanggan',
      'share_title' => 'Berbagi Informasi',
      'share' => 'Kami tidak menjual informasi pribadi Anda. Kami dapat membagikan data dengan penyedia layanan pihak ketiga yang membantu mengoperasikan aplikasi kami (misalnya, hosting cloud, pengiriman email).',
      'security_title' => 'Keamanan Data',
      'security' => 'Kami menerapkan langkah-langkah teknis dan organisasi yang sesuai untuk melindungi data pribadi Anda. Namun, tidak ada transmisi atau penyimpanan elektronik yang 100% aman.',
      'cookies_title' => 'Cookie',
      'cookies' => 'Kami menggunakan cookie sesi untuk mengautentikasi Anda dan menjaga sesi Anda. Anda dapat mengontrol preferensi cookie di pengaturan browser.',
      'contact_title' => 'Hubungi Kami',
      'contact' => 'Jika Anda memiliki pertanyaan tentang Kebijakan Privasi ini, hubungi kami di ',
      'contact_link' => 'admin@novaardiansyah.id',
    ],
  ];
  $t = $texts[$lang];
@endphp

@extends('layouts.public')

@section('title', $t['title'])

@section('content')
  <div class="card card-outline card-primary" style="max-width: 900px; margin: 0 auto;">
    <div class="card-body p-4">
      <div class="text-center mb-4">
        <div class="btn-group btn-group-sm" role="group">
          <a href="{{ url()->current() }}?lang=en" class="btn btn-outline-secondary {{ $lang === 'en' ? 'active' : '' }}">English</a>
          <a href="{{ url()->current() }}?lang=id" class="btn btn-outline-secondary {{ $lang === 'id' ? 'active' : '' }}">Indonesia</a>
        </div>
      </div>

      <h3 class="text-center">{{ $t['title'] }}</h3>
      <p class="text-center text-muted small">{{ $t['updated'] }}</p>

      <p>{{ $t['intro'] }}</p>

      <h5 class="mt-4">{{ $t['collect_title'] }}</h5>
      <ul>
        <li>{{ $t['collect_1'] }}</li>
        <li>{{ $t['collect_2'] }}</li>
        <li>{{ $t['collect_3'] }}</li>
        <li>{{ $t['collect_4'] }}</li>
      </ul>

      <h5 class="mt-4">{{ $t['use_title'] }}</h5>
      <ul>
        <li>{{ $t['use_1'] }}</li>
        <li>{{ $t['use_2'] }}</li>
        <li>{{ $t['use_3'] }}</li>
        <li>{{ $t['use_4'] }}</li>
      </ul>

      <h5 class="mt-4">{{ $t['share_title'] }}</h5>
      <p>{{ $t['share'] }}</p>

      <h5 class="mt-4">{{ $t['security_title'] }}</h5>
      <p>{{ $t['security'] }}</p>

      <h5 class="mt-4">{{ $t['cookies_title'] }}</h5>
      <p>{{ $t['cookies'] }}</p>

      <h5 class="mt-4">{{ $t['contact_title'] }}</h5>
      <p>{{ $t['contact'] }}<a href="mailto:{{ $t['contact_link'] }}">{{ $t['contact_link'] }}</a></p>

      <div class="text-center mt-4">
              <a href="{{ route('landing') }}" class="btn btn-primary">Back to Home</a>
            </div>
    </div>
  </div>
@endsection
