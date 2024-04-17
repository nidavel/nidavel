@php
    $widgets = loadWidgets('right-sidebar');
@endphp

<div class="sidebar-container">
    <div class="sticky top-40">
        @if (!empty($widgets))
        <div class="flex flex-col gap-4">
            @foreach ($widgets as $widget)
                <div class="flex flex-col gap-2">
                    <div class="widget-title">
                        {{ getWidgetTitle('right-sidebar', $widget->name) }}
                    </div>
                    <div class="widget-body">
                        {!! getWidgetBody($widget) !!}
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
