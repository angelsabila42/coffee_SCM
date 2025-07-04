/*const hamburger= document.querySelector(".toggle-btn");
const toggler = document.querySelector("#icon");

hamburger.addEventListener("click", function(){
    document.querySelector("#sidebar").classList.toggle("expand");
    toggler.classList.toggle("bxs-chevrons-right");
    toggler.classList.toggle("bxs-chevrons-left");
});*/

/** document.addEventListener('alpine:init', ()=>{
    Alpine.data('counter',()=>({
        count:0,
        name:'Mario',

        logCount(){
            console.log(this.count);
        },
    }))
})**/

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
        orderID: null,

        init() {
            window.addEventListener('open-delete-modal', (e) => { 
                this.orderID = e.detail.id;

                $('#confirmModal').modal('show');
            });
        },

        confirmDelete(){
            try{Livewire.dispatch('deleteConfirmed', {id:this.orderID});

            $('#confirmModal').modal('hide');}
            catch(error){
                console.warn('Livewire Component Missing', error);
            }
        }
    }));

    Alpine.data('tab',() => ({
        showTab1: true,
        showTab2: false,
    }));

})

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

