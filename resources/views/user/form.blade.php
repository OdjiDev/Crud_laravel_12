<div class="mb-3">
    <label class="form-label">Nom utilisateur *</label>
    <input type="text" name="nom" class="form-control" value="{{ old('nom', $user->nom ?? '') }}">
    @error('nom')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Prenom</label>
    <textarea name="prenom" class="form-control">{{ old('prenom', $user->prenom ?? '') }}</textarea>
    @error('prenom')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <textarea name="email" class="form-control">{{ old('email', $user->email ?? '') }}</textarea>
    @error('email')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Telephone *</label>
    <input type="numeric" name="telephone" step="0.01" class="form-control"
        value="{{ old('telephone', $user->telephone ?? '') }}">
    @error('telephone')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Role</label>
    <input type="text" name="role" class="form-control" value="{{ old('role', $user->role ?? '') }}">
    @error('role')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>



<div class="mb-3">
    <label class="form-label">Password *</label>
    <input type="text" name="passvord" class="form-control" value="{{ old('passvord', $user->passvord ?? '') }}">
    @error('passvord')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Status *</label>
    <select name="status" class="form-select">
        <option value="active" {{ (old('status', $user->status ?? '') == 'active') ? 'selected' : '' }}>Active</option>
        <option value="in-active" {{ (old('status', $user->status ?? '') == 'in-active') ? 'selected' : '' }}>Inactive
        </option>
    </select>
    @error('status')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

