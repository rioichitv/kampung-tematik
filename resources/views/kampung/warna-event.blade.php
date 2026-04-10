<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Kampung Warna-Warni Jodipan</title>

  <link rel="stylesheet" href="{{ asset('css/csswarna.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="event-body">
  @include('kampung.partials.navbar-warna')

  @php($events = $events ?? collect())
  <main id="event" class="event-page">
    <div class="container">
      <h2>Event</h2>
      <div class="event-stack">
        @forelse($events as $event)
        <article class="event-panel">
          <div class="event-panel__image">
            @if($event->jenis === 'foto' && $event->media_path)
              <img src="{{ asset($event->media_path) }}" alt="{{ $event->judul ?? 'Event' }}">
            @elseif($event->media_path)
              <a href="{{ asset($event->media_path) }}" target="_blank" rel="noopener" class="badge-type">Lihat Video</a>
            @else
              <div class="badge-type">Tidak ada media</div>
            @endif
          </div>
          <div class="event-panel__body">
            <h3>{{ $event->judul ?? 'Event Kampung Warna' }}</h3>
            <p>{{ $event->deskripsi ?? 'Coming soon.' }}</p>
          </div>
        </article>
        @empty
          <div style="padding:20px; text-align:center; color:#6b7280;">Coming soon.</div>
        @endforelse
      </div>
      @if($events instanceof \Illuminate\Pagination\AbstractPaginator)
      <div style="margin-top:14px;">
        {{ $events->links('pagination::bootstrap-4') }}
      </div>
      @endif
    </div>
  </main>

  @include('kampung.partials.footer-warna')
</body>
</html>
