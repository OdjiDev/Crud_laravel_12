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
    <input type="text" name="telephone" step="0.01" class="form-control"
        value="{{ old('telephone', $user->telephone ?? '') }}">
    @error('telephone')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Role</label>    
  <select name="role" class="form-select">
    <option value="ADMIN">Administrateur</option> <!-- "admin" en mAJUSCULE -->
    <option value="USER">Utilisateur</option>
    <option value="MANAGER">Manager</option>
</select>
    @error('role')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>



<div class="mb-3">
    <label class="form-label">Password *</label>
    <input type="text" name="password" class="form-control" value="{{ old('password', $user->password ?? '') }}">
    @error('password')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Statut *</label>
    <select name="statut" class="form-select">
        <option value="Active" {{ (old('statut', $user->statut ?? '') == 'active') ? 'selected' : '' }}>Active</option>
        <option value="Inactive" {{ (old('statut', $user->statut ?? '') == 'inactive') ? 'selected' : '' }}>Inactive
        </option>
    </select>
    @error('statut')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

