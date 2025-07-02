@props(['tabs'])

@php
    $first_key = is_array($tabs) ? array_key_first($tabs) : null;
@endphp

<div x-data="{activeTab: localStorage.getItem('tab') || {{ $first_key }}}"
     x-init= "$watch('activeTab', val=> localStorage.setItem('tab', val))" class="container">
    <div class="modern-tabs mb-5">

    
    <ul class="nav nav-tabs" id="filledTabs" role="tablist">
        @foreach($tabs as $key => $title)
            <li class="nav-item" role="presentation">
                <a class="nav-link" 
                   :class="{'active': activeTab === '{{$key}}'}"
                   @@click.prevent= "activeTab = '{{$key}}'"
                    href="#"
                    role="tab">
                        {{$title}} 
                    </a>
            </li>
        @endforeach
    </ul>
        
    <div class="tab-content" id="filledTabsContent">
        @foreach($tabs as $key => $title)
            <div class="tab-pane fade "
                 :class="{'show active': activeTab === '{{$key}}'}"
                 role="tabpanel">

                @if($key == 'incoming')
                    <h4 class = "card-header">{{$title}}</h4>
                        <div class = "card-body pt-0">
                            <livewire:incoming-order-table/>
                        </div>
                @elseif($key == 'outgoing')
                <h4 class = "card-header">{{$title}}</h4>
                        <div class = "card-body pt-0">
                            <livewire:outgoing-order-table/>
                        </div>
                {{-- @elseif($key == 'vendor-order')
                        <div class = "card-body pt-0">
                            <livewire:admin-recent-orders-table/>
                        </div>         --}}
                @endif
            </div>
             @endforeach
        
    </div>
    </div>
</div>




 







