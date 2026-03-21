@php $user = $user ?? null; @endphp
<div class="row g-3">
    <div class="col-12">
        <label class="form-label small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $user?->name) }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-8">
        <label class="form-label small fw-semibold">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $user?->email) }}" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Role <span class="text-danger">*</span></label>
        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
            <option value="user"  {{ old('role',$user?->role)==='user'?'selected':'' }}>User (Orang Tua)</option>
            <option value="guru"  {{ old('role',$user?->role)==='guru'?'selected':'' }}>Guru</option>
            <option value="admin" {{ old('role',$user?->role)==='admin'?'selected':'' }}>Admin</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">
            {{ $user ? 'Password Baru' : 'Password' }}
            @if(!$user)<span class="text-danger">*</span>@else<span class="text-muted">(opsional)</span>@endif
        </label>
        <input type="password" name="{{ $user ? 'new_password' : 'password' }}"
               class="form-control @error('password') is-invalid @enderror"
               placeholder="Minimal 8 karakter" {{ $user ? '' : 'required' }}>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">No. Telepon</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user?->phone) }}">
    </div>
    <div class="col-12">
        <label class="form-label small fw-semibold">Alamat</label>
        <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $user?->alamat) }}</textarea>
    </div>
</div>
