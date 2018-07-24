<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="list-group" id="profile-menu">
    <a href="/en/profile" class="list-group-item list-group-item-action rounded-0" id="profile-menu-data">Your Profile</a>
    <a href="/en/profile/change-password" class="list-group-item list-group-item-action rounded-0" id="profile-menu-password">Change Password</a>
    <a href="/en/profile/addresses/billing" class="list-group-item list-group-item-action rounded-0" id="profile-menu-billing-addresses">Your Billing Addresses</a>
    <a href="/en/profile/addresses/billing/new" class="list-group-item list-group-item-action rounded-0" id="profile-menu-billing-addresses-new" hidden>New</a>
    <a href="/en/profile/addresses/billing/edit/<?php echo htmlspecialchars( $value["idaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="list-group-item list-group-item-action rounded-0" id="profile-menu-billing-addresses-edit" hidden>Address #<?php echo htmlspecialchars( $seqaddress, ENT_COMPAT, 'UTF-8', FALSE ); ?> - Edit</a>
    <a href="/en/profile/addresses/shipping" class="list-group-item list-group-item-action rounded-0" id="profile-menu-shipping-addresses">Your Shipping Addresses</a>
    <a href="/en/profile/addresses/shipping/new" class="list-group-item list-group-item-action rounded-0" id="profile-menu-shipping-addresses-new" hidden>New</a>
    <a href="/en/profile/addresses/shipping/edit/<?php echo htmlspecialchars( $value["idaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="list-group-item list-group-item-action rounded-0" id="profile-menu-shipping-addresses-edit" hidden>Address #<?php echo htmlspecialchars( $seqaddress, ENT_COMPAT, 'UTF-8', FALSE ); ?> - Edit</a>
    <a href="/en/profile/orders" class="list-group-item list-group-item-action rounded-0" id="profile-menu-orders">Your Orders</a>
    <a href="/en/profile/orders" class="list-group-item list-group-item-action rounded-0" id="profile-menu-orders-details" hidden>Order #<?php echo htmlspecialchars( $order["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?> - Details</a>
    <a href="/en/profile/wishlist" class="list-group-item list-group-item-action rounded-0" id="profile-menu-wishlist">Your Wishlist</a>
    <a href="/en/logout" class="list-group-item list-group-item-action rounded-0" id="profile-menu-logout">Logout</a>
</div>