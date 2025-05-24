@extends('layouts.app')

@section('content')
    <livewire:project-wizard />
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        startDateInput.addEventListener('change', function() {
            endDateInput.min = this.value;
        });

        endDateInput.addEventListener('change', function() {
            startDateInput.max = this.value;
        });

        const resourcesInput = document.getElementById('resources');
        const servicesInput = document.getElementById('services');

        [resourcesInput, servicesInput].forEach(input => {
            if (input) {
                input.addEventListener('change', function() {
                    const items = this.value.split(',').map(item => item.trim());
                    this.value = items.join(', ');
                });
            }
        });
    });
</script>
@endpush
