$(document).ready(function() {
// Function for Preview Image.
$(function() {
$(":file").change(function() {
if (this.files && this.files[0]) {
var reader = new FileReader();
reader.onload = imageIsLoaded;
reader.readAsDataURL(this.files[0]);
}
});
});
function imageIsLoaded(e) {
$('#message').css("display", "none");
$('#preview').css("display", "block");
$('#previewimg').attr('src', e.target.result);
};

// Function for Displaying Details of Uploaded Image.
$("#submit").click(function() {
$('#preview').css("display", "none");
$('#message').css("display", "block");
});
});
