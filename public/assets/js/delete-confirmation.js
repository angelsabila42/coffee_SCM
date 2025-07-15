function confirmDelete(form, reportId) {
    Swal.fire({
        title: 'Delete Report?',
        text: `Are you sure you want to delete QA Report ${reportId}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
