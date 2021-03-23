function confirmBox() {
    
    var confirmation = confirm("Publishing this note will send note to administrator for review, once administrator review and approve then this note will be published to portal. Press yes to continue.");
    
    if(confirmation == true) {
        window.location.href = "dashboard.html";
    }
}