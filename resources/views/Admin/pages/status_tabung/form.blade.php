<div class="form-group">
    <label for="status_tabung">Status Tabung</label>
    <select name="status_tabung" class="form-control" required>
        <option value="">-- Pilih Status --</option>
        @foreach(['tersedia', 'dipinjam', 'rusak', 'hilang'] as $status)
            <option value="{{ $status }}" {{ (isset($current) && $current == $status) ? 'selected' : '' }}>
                {{ ucfirst($status) }}
            </option>
        @endforeach
    </select>
</div>
