@extends('home.home-admin.layouts.layout')

@section('title', 'Tambah Event - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Tambah Event</h2>
    
    <!-- Form Tambah Event -->
    <form action="{{ route('admin.events.store') }}" method="POST">
      @csrf
      <div class="mb-4">
        <label for="event-name" class="block text-gray-700">Nama Event:</label>
        <input type="text" name="event_name" id="event-name" class="w-full p-2 border rounded-md" placeholder="EVENT-098-1238" required>
      </div>
      
      <div class="mb-4">
        <label for="start-date" class="block text-gray-700">Tanggal Mulai Event:</label>
        <input type="date" name="start_date" id="start-date" class="w-full p-2 border rounded-md" required>
      </div>
      
      <div class="mb-4">
        <label for="end-date" class="block text-gray-700">Tanggal Berakhir Event:</label>
        <input type="date" name="end_date" id="end-date" class="w-full p-2 border rounded-md" required>
      </div>
      
      <div class="mb-4">
        <label for="event-type" class="block text-gray-700">Tipe Event:</label>
        <input type="text" name="event_type" id="event-type" class="w-full p-2 border rounded-md" placeholder="Offline/Online" required>
      </div>
      
      <div class="mb-4">
        <label for="event-scheme" class="block text-gray-700">Nama Skema:</label>
        <div id="schemes-list">
          <input type="text" name="event_scheme[]" class="w-full p-2 border rounded-md mb-2" placeholder="SKM-XXXX" required>
        </div>
        <button type="button" id="add-scheme" class="bg-blue-500 text-white p-2 rounded">Tambah Skema</button>
      </div>
      
      <div class="flex justify-end">
        <button type="submit" class="bg-green-500 text-white p-2 rounded">Simpan Event</button>
      </div>
    </form>
  </div>
</div>

<script>
  // JavaScript untuk menangani penambahan skema input
  document.getElementById('add-scheme').addEventListener('click', function() {
    var newSchemeInput = document.createElement('input');
    newSchemeInput.type = 'text';
    newSchemeInput.name = 'event_scheme[]';
    newSchemeInput.classList.add('w-full', 'p-2', 'border', 'rounded-md', 'mb-2');
    newSchemeInput.placeholder = 'SKM-XXXX';
    
    document.getElementById('schemes-list').appendChild(newSchemeInput);
  });
</script>

@endsection
