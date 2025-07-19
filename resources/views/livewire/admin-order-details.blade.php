
<div class="d-flex">
                <button type= "button" class="btn save mr-2" wire:click="acceptOrder">Accept</button>
                <button type= "button" class="btn exit" @@click="showForm= !showForm"  wire:click="declineOrder">Decline</button>
</div>