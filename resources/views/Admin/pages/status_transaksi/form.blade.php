<div class="form-group">
  <label for="status">Status Transaksi</label>
  <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
    <option value="">-- Pilih Status --</option>
    <option value="success" {{ old('status', $statusTransaksi->status ?? '') == 'success' ? 'selected' : '' }}>Success</option>
    <option value="pending" {{ old('status', $statusTransaksi->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
    <option value="failed"  {{ old('status', $statusTransaksi->status ?? '') == 'failed'  ? 'selected' : '' }}>Failed</option>
  </select>
  @error('status')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
