@php $v = fn($field) => old($field, $usuario?->$field ?? ''); @endphp

<div>
    <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Username <span class="text-red-500">*</span></label>
    <input type="text" name="username" value="{{ $v('username') }}" required
           class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
</div>

<div>
    <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Email <span class="text-red-500">*</span></label>
    <input type="email" name="email" value="{{ $v('email') }}" required
           class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
</div>

<div>
    <label class="block text-sm font-medium text-[#1E2749] mb-1.5">
        Contraseña {{ $passwordRequired ? '*' : '(dejar vacío para no cambiar)' }}
    </label>
    <input type="password" name="password" {{ $passwordRequired ? 'required' : '' }}
           class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
</div>

<div>
    <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Confirmar contraseña {{ $passwordRequired ? '*' : '' }}</label>
    <input type="password" name="password_confirmation" {{ $passwordRequired ? 'required' : '' }}
           class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
</div>

<div>
    <label class="block text-sm font-medium text-[#1E2749] mb-1.5">Rol <span class="text-red-500">*</span></label>
    <select name="role" required class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#004494]/30">
        <option value="editor"      {{ $v('role') === 'editor'      ? 'selected' : '' }}>Editor</option>
        <option value="admin"       {{ $v('role') === 'admin'       ? 'selected' : '' }}>Admin</option>
        <option value="super_admin" {{ $v('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
    </select>
</div>
