@php
  $texts = [
    'en' => [
      'title' => 'Terms of Service',
      'updated' => 'Last updated: July 6, 2026',
      'intro' => 'By using Easy Ticket AI ("the Service"), you agree to these Terms of Service. If you do not agree, do not use the Service.',
      'accept_title' => 'Acceptance of Terms',
      'accept' => 'By accessing or using the Service, you confirm that you have read, understood, and agree to be bound by these Terms.',
      'account_title' => 'Account Responsibilities',
      'account_1' => 'You must provide accurate and complete information when creating an account.',
      'account_2' => 'You are responsible for maintaining the confidentiality of your login credentials.',
      'account_3' => 'You must notify us immediately of any unauthorized use of your account.',
      'use_title' => 'Acceptable Use',
      'use_1' => 'You may not use the Service for any unlawful purpose.',
      'use_2' => 'You may not attempt to disrupt, damage, or impair the Service.',
      'use_3' => 'You may not access or attempt to access other users\' accounts.',
      'ip_title' => 'Intellectual Property',
      'ip' => 'The Service and its original content, features, and functionality are owned by Easy Ticket AI and are protected by applicable intellectual property laws.',
      'limitation_title' => 'Limitation of Liability',
      'limitation' => 'The Service is provided "as is" without warranties of any kind. We shall not be liable for any indirect, incidental, or consequential damages arising from your use of the Service.',
      'termination_title' => 'Termination',
      'termination' => 'We reserve the right to suspend or terminate your account at any time for violation of these Terms or for any other reason at our discretion.',
      'changes_title' => 'Changes to Terms',
      'changes' => 'We may modify these Terms at any time. Continued use of the Service after changes constitutes acceptance of the new Terms.',
      'contact_title' => 'Contact',
      'contact' => 'For questions about these Terms, contact us at ',
      'contact_link' => 'admin@novaardiansyah.id',
    ],
    'id' => [
      'title' => 'Ketentuan Layanan',
      'updated' => 'Terakhir diperbarui: 6 Juli 2026',
      'intro' => 'Dengan menggunakan Easy Ticket AI ("Layanan"), Anda menyetujui Ketentuan Layanan ini. Jika tidak setuju, jangan gunakan Layanan.',
      'accept_title' => 'Penerimaan Ketentuan',
      'accept' => 'Dengan mengakses atau menggunakan Layanan, Anda menyatakan telah membaca, memahami, dan setuju terikat oleh Ketentuan ini.',
      'account_title' => 'Tanggung Jawab Akun',
      'account_1' => 'Anda harus memberikan informasi yang akurat dan lengkap saat membuat akun.',
      'account_2' => 'Anda bertanggung jawab menjaga kerahasiaan kredensial login Anda.',
      'account_3' => 'Anda harus segera memberi tahu kami tentang penggunaan akun yang tidak sah.',
      'use_title' => 'Penggunaan yang Diizinkan',
      'use_1' => 'Anda tidak boleh menggunakan Layanan untuk tujuan melanggar hukum.',
      'use_2' => 'Anda tidak boleh mencoba mengganggu, merusak, atau mengganggu Layanan.',
      'use_3' => 'Anda tidak boleh mengakses atau mencoba mengakses akun pengguna lain.',
      'ip_title' => 'Kekayaan Intelektual',
      'ip' => 'Layanan dan konten asli, fitur, serta fungsionalitasnya dimiliki oleh Easy Ticket AI dan dilindungi oleh hukum kekayaan intelektual yang berlaku.',
      'limitation_title' => 'Batas Tanggung Jawab',
      'limitation' => 'Layanan disediakan "apa adanya" tanpa jaminan apa pun. Kami tidak bertanggung jawab atas kerugian tidak langsung, insidental, atau konsekuensial yang timbul dari penggunaan Layanan.',
      'termination_title' => 'Penghentian',
      'termination' => 'Kami berhak menangguhkan atau menghentikan akun Anda kapan saja karena pelanggaran Ketentuan ini atau alasan lain sesuai kebijakan kami.',
      'changes_title' => 'Perubahan Ketentuan',
      'changes' => 'Kami dapat mengubah Ketentuan ini kapan saja. Penggunaan Layanan setelah perubahan merupakan penerimaan Ketentuan baru.',
      'contact_title' => 'Kontak',
      'contact' => 'Untuk pertanyaan tentang Ketentuan ini, hubungi kami di ',
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

      <h5 class="mt-4">{{ $t['accept_title'] }}</h5>
      <p>{{ $t['accept'] }}</p>

      <h5 class="mt-4">{{ $t['account_title'] }}</h5>
      <ul>
        <li>{{ $t['account_1'] }}</li>
        <li>{{ $t['account_2'] }}</li>
        <li>{{ $t['account_3'] }}</li>
      </ul>

      <h5 class="mt-4">{{ $t['use_title'] }}</h5>
      <ul>
        <li>{{ $t['use_1'] }}</li>
        <li>{{ $t['use_2'] }}</li>
        <li>{{ $t['use_3'] }}</li>
      </ul>

      <h5 class="mt-4">{{ $t['ip_title'] }}</h5>
      <p>{{ $t['ip'] }}</p>

      <h5 class="mt-4">{{ $t['limitation_title'] }}</h5>
      <p>{{ $t['limitation'] }}</p>

      <h5 class="mt-4">{{ $t['termination_title'] }}</h5>
      <p>{{ $t['termination'] }}</p>

      <h5 class="mt-4">{{ $t['changes_title'] }}</h5>
      <p>{{ $t['changes'] }}</p>

      <h5 class="mt-4">{{ $t['contact_title'] }}</h5>
      <p>{{ $t['contact'] }}<a href="mailto:{{ $t['contact_link'] }}">{{ $t['contact_link'] }}</a></p>

      <div class="text-center mt-4">
              <a href="{{ route('landing') }}" class="btn btn-primary">Back to Home</a>
            </div>
    </div>
  </div>
@endsection
