<div x-data= "confirmDeleteModal" x-init= "init()">
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-exclamation-triangle warning-icon"></i>
                <p class="mb-0">Are you sure you want to delete this item?<br>This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-fill" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2 "></i>Cancel
                    </button>
                <button type="button" class="btn btn-danger btn-fill" @@click="confirmDelete">
                        <i class="fas fa-trash-alt me-2"></i>Delete
                    </button>
            </div>
        </div>
    </div>
</div>
</div>