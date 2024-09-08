<h2>Daftar Pelatihan</h2>
<table>
    <thead>
        <tr>
            <th>Nama Pelatihan</th>
            <th>Instruktur</th>
            <th>Mulai</th>
            <th>Selesai</th>
        </tr>
    </thead>
    <tbody>
        @foreach($trainings as $training)
        <tr>
            <td>{{ $training->name }}</td>
            <td>{{ $training->instructor->name }}</td>
            <td>{{ $training->start_date }}</td>
            <td>{{ $training->end_date }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h2>Tambah Pelatihan Baru</h2>
<form action="{{ route('trainings.store') }}" method="POST">
    @csrf
    <label>Nama:</label>
    <input type="text" name="name" required><br>

    <label>Deskripsi:</label>
    <textarea name="description"></textarea><br>

    <label>Mulai:</label>
    <input type="date" name="start_date" required><br>

    <label>Selesai:</label>
    <input type="date" name="end_date" required><br>

    <label>Kapasitas:</label>
    <input type="number" name="capacity" required><br>

    <label>Instruktur:</label>
    <select name="instructor_id" required>
        @foreach($instructors as $instructor)
            <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
        @endforeach
    </select><br>

    <button type="submit">Tambah Pelatihan</button>
</form>




