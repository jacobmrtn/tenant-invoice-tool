<?php 

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $post_info = json_decode(file_get_contents('php://input'), true);
    $tenant_name = $post_info["tenant_name"];
    $tenant_address = $post_info["tenant_address"];
    $monthly_rent = $post_info["monthly_rent"];
    $rent_due_date = $post_info["rent_due_date"];
    $rental_owner = $post_info["rental_owner"];
    $owner_address = $post_info["owner_address"];
    $owner_name = $post_info["owner_name"];

    $file_name = "print.php";

    $print = '
    <style>
    .header {
        text-align: center;
    }

    .right-align {
        text-align: right;
    }
    </style>

    <div class="notice">
        <div class="header">
            <h1>5-DAY LATE RENT NOTICE</h1>
            <h3 data-fill="owner_name">'. $owner_name . '</h3>
            <h3 data-fill="owner_address">' . $owner_address .'</h3>
            <h3>(518) 929-5872</h3>
        </div>
        <p id="todays_date"><strong>Date:</strong> ' . date('m/d/Y') .  '</p>
        <br>
        <p><strong>To:</strong></p>
        <p data-fill="tenant_name">'. $tenant_name.'</p>
        <p data-fill="tenant_address">'. $tenant_address.'</p>
        <br>
        <p><strong>Landlord:</strong></p>
        <p data-fill="owner_name">'. $owner_name . '</p>
        <p data-fill="owner_address">' . $owner_address .'</p>
        <br>
        <p><strong>Re:</strong></string></p>
        <p data-append="tenant_address">Apartment: '. $tenant_address . '</p>
        <p data-fill="monthly_rent">Rents Due:' . $monthly_rent. '</p>
        <p>month 1:$</p>
        <br>
        <p>Dear Tenant:</p>
        <br>
        <p>PLEASE TAKE NOTICE that you are now 5 days past due on rent payment the sum stated above is due in full for the rental of the above property, now occupied by you as a tenant and of which the undersigned are your Landlords, or deliver possession of the said property to the Landlords within the said fourteen days.</p>
        <br>
        <p>IN ADDITION, as per N. Y.G.O.L. § 7-108, you have a right to request a pre-moveout inspection before you vacate the premises. If you request such an inspection, you have a right to be present and the inspection must be 1-2 weeks before you vacate the apartment with 48 hours notice. You also have the right to cure any inspection failures prior to the final move-out inspection.</p>

        <p class="right-align thanks">Thanks,</p>

        <p class="right-align owners-name" data-fill="owner_name">'. $owner_name . '</p>
    </div>';

    file_put_contents($file_name, $print);

    echo date('Ymd') . '-' . $tenant_name;
} else {
    header("Location ../tenants.php");  
    die();
}