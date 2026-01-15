@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Create Role</h5>
            <a href="{{ route('access.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('access.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name') }}" placeholder="e.g. Editor, Moderator" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="select_all">
                        <label class="form-check-label fw-bold" for="select_all">
                            Select All Permissions
                        </label>
                    </div>
                </div>

                <hr>

                <div class="row">
                    @php
                        $groupedPermissions = $permissions->groupBy(function ($perm) {
                            $parts = explode('_', $perm->name, 2);
                            return isset($parts[1]) ? $parts[1] : 'Other';
                        });
                    @endphp

                    @foreach ($groupedPermissions as $group => $perms)
                        <div class="col-12 mb-4">
                            <div class="card border">
                                <div class="card-header bg-light py-2">
                                    <div class="form-check">
                                        <input class="form-check-input group-select" type="checkbox"
                                            data-group="{{ \Illuminate\Support\Str::slug($group) }}"
                                            id="group_{{ \Illuminate\Support\Str::slug($group) }}">
                                        <label class="form-check-label fw-bold text-uppercase"
                                            for="group_{{ \Illuminate\Support\Str::slug($group) }}">
                                            {{ str_replace('_', ' ', $group) }} Management
                                        </label>
                                    </div>
                                </div>
                                <div class="card-body py-3">
                                    <div class="row">
                                        @foreach ($perms as $permission)
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input perm-checkbox group-{{ \Illuminate\Support\Str::slug($group) }}"
                                                        type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                        id="perm_{{ $permission->id }}"
                                                        {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label text-capitalize"
                                                        for="perm_{{ $permission->id }}">
                                                        {{ str_replace('_', ' ', $permission->name) }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Create Role</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Select All
            $('#select_all').on('change', function() {
                $('.perm-checkbox').prop('checked', $(this).is(':checked'));
                $('.group-select').prop('checked', $(this).is(':checked'));
            });

            // Group Select
            $('.group-select').on('change', function() {
                var group = $(this).data('group');
                $('.group-' + group).prop('checked', $(this).is(':checked'));
                checkAllStatus();
            });

            // Individual Checkbox
            $('.perm-checkbox').on('change', function() {
                var groupClass = $(this).attr('class').split(' ').find(c => c.startsWith('group-'));
                var groupSlug = groupClass.replace('group-', '');
                checkGroupStatus(groupSlug);
                checkAllStatus();
            });

            // Initial Check on Load (for Old Input)
            $('.group-select').each(function() {
                var group = $(this).data('group');
                checkGroupStatus(group);
            });
            checkAllStatus();

            function checkGroupStatus(groupSlug) {
                var allChecked = $('.group-' + groupSlug).length === $('.group-' + groupSlug + ':checked').length;
                $('#group_' + groupSlug).prop('checked', allChecked);
            }

            function checkAllStatus() {
                var allChecked = $('.perm-checkbox').length === $('.perm-checkbox:checked').length;
                $('#select_all').prop('checked', allChecked);
            }
        });
    </script>
@endpush
