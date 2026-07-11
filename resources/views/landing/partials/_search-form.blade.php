@push('styles')
<style>
.flatpickr-calendar.animate.open {
  min-width: 330px !important;
}
</style>
@endpush

<form method="POST" action="{{ route('landing.search.process') }}" id="search-form">
  @csrf
  <div class="row g-3 align-items-end">
    <div class="col-md">
      <div class="d-flex align-items-end gap-2">
        <div class="flex-grow-1" style="min-width: 0;">
          <label class="form-label fw-semibold small">Stasiun Asal</label>
          <select name="origin_station_id" id="origin_station_id" class="form-select select2" required>
            <option value="">Pilih Stasiun Asal</option>
            @foreach ($stations as $s)
            <option value="{{ $s->id }}" {{ (string)$originId === (string)$s->id ? 'selected' : '' }}>{{ $s->city }} - {{ $s->name }} ({{ $s->code }})</option>
            @endforeach
          </select>
        </div>
        <button type="button" id="swap-stations-btn" class="btn-swap-stations flex-shrink-0" title="Tukar stasiun asal & tujuan">
          <i class="bi bi-arrow-left-right"></i>
        </button>
        <div class="flex-grow-1" style="min-width: 0;">
          <label class="form-label fw-semibold small">Stasiun Tujuan</label>
          <select name="destination_station_id" id="destination_station_id" class="form-select select2" required>
            <option value="">Pilih Stasiun Tujuan</option>
            @foreach ($stations as $s)
            <option value="{{ $s->id }}" {{ (string)$destinationId === (string)$s->id ? 'selected' : '' }}>{{ $s->city }} - {{ $s->name }} ({{ $s->code }})</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
    <div class="col-md-auto">
      <label class="form-label fw-semibold small">Tanggal Keberangkatan</label>
      <input type="text" name="departure_date" id="departure_date" class="form-control bg-white" value="{{ $departureDate ?? '' }}" placeholder="Pilih Tanggal" required readonly style="background-color: #ffffff !important;">
    </div>
    <div class="col-md-auto">
      <button type="submit" class="btn btn-primary py-2"><i class="bi bi-search me-2"></i>Cari</button>
    </div>
  </div>
</form>
