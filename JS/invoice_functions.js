get_date();
fill_owner_name();
fill_tenant_name();
fill_tenant_address();
append_tenant_address();
fill_rent_due();
fill_owner_address();
// get todays date
function get_date() {
    document.getElementById('todays_date').innerHTML += new Date().toDateString()
}

function fill_owner_name() {
    let owner_names = document.querySelectorAll('[data-fill="owner_name"]');
    
    owner_names.forEach((element) => {
        element.innerHTML = "Jacob Martin";
    })
    
}

function fill_tenant_name() {
    let tenant_names = document.querySelectorAll('[data-fill="tenant_name"]');

    tenant_names.forEach((element) => {
        element.innerHTML = "Luke Matts";
    })

}

function fill_tenant_address() {
    let tenant_address = document.querySelectorAll('[data-fill="tenant_address"]');

    tenant_address.forEach((element) => {
        element.innerHTML = "35 Corliss Ave";
    })
}


function append_tenant_address() {
    let tenant_address = document.querySelectorAll('[data-append="tenant_address"]');

    tenant_address.forEach((element) => {
        element.innerHTML += "35 Corliss Ave";
    })
}

function fill_rent_due() {
    let monthly_rents = document.querySelectorAll('[data-fill="monthly_rent"]');

    monthly_rents.forEach((element) => {
        element.innerHTML = "Rents Due: $1,700"; 
    })
}

function fill_owner_address() {
    let owner_address = document.querySelectorAll('[data-fill="owner_address"]');

    owner_address.forEach((element) => {
        element.innerHTML = "311 Rockport Ave, Bave KT"
    })

}