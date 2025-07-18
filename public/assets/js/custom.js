document.addEventListener('alpine:init', ()=>{
    Alpine.data('signupForm',() => ({
        username: '',
        password: '',
        passwordConfirm: '',
        belt: '',
        bio: '',
        newsletter:true,
        showPass:false,
        errors:{},
        beltChoices:['black','red','white','orange','brown'],
        success: false,

        validateForm(){
            this.errors = {}

            if (this.username.length < 3){
                this.errors.username = 'Username must be atleast 3 characters.'
            }
              if (this.password.length < 6){
                this.errors.password = 'Password must be atleast 6 characters.'
            }
              if (this.password !== this.passwordConfirm){
                this.errors.passwordConfirm = 'Passwords do not match.'
            }
              if (!this.belt){
                this.errors.belt = 'Please select a belt'
            }
              if (this.bio.length < 10){
                this.errors.bio = 'Bio must be atleast 10 characters'
            }
        },

        submitForm($event){
            this.validateForm()
            console.log(this.errors)

            if(Object.keys(this.errors).length === 0){
                console.log(this.username, this.password, this.passwordConfirm, this.belt, this.bio, this.newsletter)

                this.success= true
                $event.target.reset()

            }
        }
    }));

    Alpine.data('sideBar', () => ({
        isExpanded: false,
        toggle(){
            this.isExpanded = !this.isExpanded;
        }
    }));

    Alpine.data('advancedFilter', () => ({
        showFilter: false,
        selectedCountry: '',
        selectedGrade: '',
        grades: [],
        countries: [],

        async init(){
            try{
            const countryRes = await fetch('/api/v1/incoming-order/dropdown');                
            const countryData = await countryRes.json();
            this.countries = countryData.data;

            console.log(this.countries);

            }catch(error){
                console.error('Fetch request failed', error);
            }
        },

        toggle(){
            this.showFilter = !this.showFilter;
        }

    }))

    Alpine.data('vendorDispatch',() => ({
        showModal: false,
        showForm: false,
        selectedCenter: '',
        selectedType: '',
        centers: [],
        typeNames: ['Arabica', 'Robusta'],

           async init(){
            try{
            const centerRes = await fetch('/api/v1/work-center/dropdown');

            const centersData = await centerRes.json();

            this.centers = centersData.data;;

            console.log(this.centers);

            }catch(error){
                console.error('Fetch request failed', error);
            }

            window.addEventListener('reset-alpine-dropdown', () => {
            this.selectedVendor= '';
        });

        }

    }))


    Alpine.data('adminOrderModal',() => ({
        showModal: false,
        selectedVendor: '',
        selectedCountry: '',
        selectedGrade: '',
        selectedType: '',
        selectedCenter: '',
        typeNames: ['Arabica', 'Robusta'],
        grades: ['A','B', 'C', 'screen 8'],
        countries: [],
        vendors: [],
        centers: [],

        async init(){
            try{
            const vendorRes = await fetch('/api/v1/vendor/dropdown');
            const centerRes = await fetch('/api/v1/work-center/dropdown');
            const countryRes = await fetch('/api/v1/incoming-order/dropdown');                

            const vendorData = await vendorRes.json();
            const centersData = await centerRes.json();
            const countryData = await countryRes.json();

            this.vendors = vendorData.data;
            this.centers = centersData.data;
            this.countries = countryData.data;

            console.log(this.vendors);
            console.log(this.centers);
            console.log(this.countries);

            }catch(error){
                console.error('Fetch request failed', error);
            }

            window.addEventListener('reset-alpine-dropdown', () => {
            this.selectedCenter= '';
            this.selectedType= '';
            this.selectedVendor= '';
        });

        }

    }));

    Alpine.data('importerOrderModal',() => ({
        showModal: false,
        selectedDestination: '',
        selectedGrade: '',
        selectedType: '',
        typeNames: ['Arabica', 'Robusta'],
        grades: ['A','B', 'C', 'screen 8'],
        destination: [],


        async init(){
            try{
            const destinationRes = await fetch('/api/v1/incoming-order/dropdown');                

            const countryData = await countryRes.json();

            this.countries = countryData.data;

            console.log(this.countries);

            }catch(error){
                console.error('Fetch request failed', error);
            }

            window.addEventListener('reset-alpine-dropdown', () => {
            this.selectedGrade= '';
            this.selectedType= '';
            this.selectedCountry= '';
        });

        }

    }));

    Alpine.data('confirmDeleteModal', () => ({
        //orderID: null,

        //  init() {
        //      window.addEventListener('open-delete-modal', (e) => { 
        //          this.orderID = e.detail.id;

        //          $('#confirmModal').modal('show');
        //      });
        //  },

        //  confirmDelete(){
        //      try{Livewire.dispatch('deleteConfirmed', {id:this.orderID});

        //      $('#confirmModal').modal('hide');}
        //      catch(error){
        //          console.warn('Livewire Component Missing', error);
        //      }
        //  }

        confirmDeleteOrder(id, orderID) {
    Swal.fire({
        title: 'Confirm Deletion',
        text: `Are you sure you want to delete ${orderID}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.dispatch('deleteConfirmed', {id:id});
            // Swal.fire('Deleted!', `${orderID} has been deleted.`, 'success');
        }
    });
}


     }));

});

/*document.addEventListener('livewire:load', () => {
    Livewire.on('show-toast', (message) => {
    window.dispatchEvent(new CustomEvent('show-toast', {
        detail: { message }
    }));
});
});

window.addEventListener('show-toast', e => {
    alert(e.detail.message);
});*/

// Bootstrap 5 to Bootstrap 4 Compatibility Layer
document.addEventListener('DOMContentLoaded', function() {
    // Convert data-bs-toggle to data-toggle
    document.querySelectorAll('[data-bs-toggle]').forEach(function(element) {
        var toggleValue = element.getAttribute('data-bs-toggle');
        element.setAttribute('data-toggle', toggleValue);
    });

    // Convert data-bs-target to data-target
    document.querySelectorAll('[data-bs-target]').forEach(function(element) {
        var targetValue = element.getAttribute('data-bs-target');
        element.setAttribute('data-target', targetValue);
    });

    // Convert data-bs-dismiss to data-dismiss
    document.querySelectorAll('[data-bs-dismiss]').forEach(function(element) {
        var dismissValue = element.getAttribute('data-bs-dismiss');
        element.setAttribute('data-dismiss', dismissValue);
    });

    // Fix modal buttons in Bootstrap 4
    document.querySelectorAll('.btn-close').forEach(function(element) {
        if (element.getAttribute('data-dismiss') === 'modal') {
            element.classList.add('close');
            element.innerHTML = '&times;';
        }
    });

    console.log('Bootstrap 5 to 4 compatibility layer applied');
});

  





    