@php
    $widgets = loadWidgets('right-sidebar');
@endphp

<div class="sidebar-container">
    <div class="sticky top-40">
        <div class="flex flex-col gap-2">
        @if (!empty($widgets))
            @foreach ($widgets as $widget)
                <div class="flex flex-col gap-1">
                    <div class="sidebar-widget-title">
                        {{ getWidgetTitle('right-sidebar', $widget->name) }}
                    </div>
                    <div class="sidebar-widget-body">
                        {!! getWidgetBody($widget) !!}
                    </div>
                </div>
            @endforeach
        @endif
        </div>
    </div>
</div>
